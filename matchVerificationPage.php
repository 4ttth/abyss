<?php
session_start(); // Start the session
require_once 'includes/dbh.inc.php'; // Database connection
require_once 'includes/userhomepage.inc.php'; // Squad details logic

// ====== NEW CODE START ======
// Initialize user data from session with proper fallback values
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [
    'User_ID' => 'N/A',
    'Username' => 'Guest',
    'Squad_ID' => 'N/A',
    'Role' => 'Guest'
];

// Initialize squad details with default values
$squadDetails = [
    'Squad_Acronym' => 'N/A',
    'Squad_Name' => 'N/A',
    'Squad_ID' => 'N/A',
    'Squad_Level' => 'N/A',
    'Squad_Description' => 'N/A'
];

$scrimID = isset($_GET['scrim_id']) && is_numeric($_GET['scrim_id']) ? intval($_GET['scrim_id']) : null; // TESTING LANG TO BAKS FIFTHHARMONY

// Fetch squad details only if Squad_ID exists
if (isset($user['Squad_ID']) && $user['Squad_ID'] !== 'N/A') {
    try {
        $stmtSquad = $pdo->prepare("SELECT Squad_Acronym, Squad_Name, Squad_ID, Squad_Level, Squad_Description FROM tbl_squadprofile WHERE Squad_ID = ?");
        $stmtSquad->execute([$user['Squad_ID']]);
        $squadDetails = $stmtSquad->fetch(PDO::FETCH_ASSOC) ?: $squadDetails; // Fallback to defaults if no results
        $_SESSION['squad_details'] = $squadDetails;
    } catch (PDOException $e) {
        // Handle error silently
    }
}

// Verification check (updated with null coalescing)
$verificationStatus = 'Not Submitted';
if ($user['Squad_ID'] !== 'N/A') {
    try {
        $stmt = $pdo->prepare("SELECT Status FROM tbl_verificationrequests WHERE Squad_ID = ? ORDER BY Date_Submitted DESC LIMIT 1");
        $stmt->execute([$user['Squad_ID']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $verificationStatus = $result['Status'] ?? 'Not Submitted';
    } catch (PDOException $e) {
        // Handle error silently
    }
}

// Enable scrim button logic (simplified)
$enableScrimButton = ($verificationStatus === 'Approved') || 
                    (strcasecmp($squadDetails['Squad_Level'], 'Amateur') === 0);

// ====== NEW CODE END =======

// Check verification status
if ($verificationStatus === 'Approved') {
    $enableScrimButton = true;
}

// Check squad level (case-insensitive)
if (strtoupper($squadDetails['Squad_Level']) === 'AMATEUR') {
    $enableScrimButton = true;
}

// Debug output (remove after testing)
echo '<script>console.log("Scrim Button State:", ' 
    . json_encode([
        'status' => $verificationStatus,
        'level' => $squadDetails['Squad_Level'],
        'enabled' => $enableScrimButton
    ]) 
    . ');</script>';

// Initialize players array
$players = [];


try {
    // Fetch ALL user data from the database using session username TESTING TESTING
    if (isset($_SESSION['user']['username'])) {
        $query = "SELECT * FROM tbl_useraccount WHERE Username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $_SESSION['user']['username'], PDO::PARAM_STR);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user_data) {
            // Update session with latest data (including Squad_ID)
            $_SESSION['user'] = $user_data;
            $user = $user_data; // For direct use in HTML
        }
    }


    // Fetch squad details if Squad_ID is set
    if (isset($_SESSION['user']['Squad_ID'])) {
        $squadID = $_SESSION['user']['Squad_ID'];

        // Fetch squad details
        $stmtSquad = $pdo->prepare("SELECT Squad_Acronym, Squad_Name, Squad_ID, Squad_Level, Squad_Description FROM tbl_squadprofile WHERE Squad_ID = ?");
        $stmtSquad->execute([$squadID]);
        $squadDetails = $stmtSquad->fetch(PDO::FETCH_ASSOC);


        // If no squad is found, set default values
        if (!$squadDetails) {
            $squadDetails = [
                'Squad_Acronym' => 'N/A',
                'Squad_Name' => 'N/A',
                'Squad_ID' => 'N/A',
                'Squad_Level' => 'N/A',
                'Squad_Description' => 'N/A'
            ];
        }


        // Update session with the latest squad details
        $_SESSION['squad_details'] = $squadDetails;


        // Fetch players for the squad
        $stmtPlayers = $pdo->prepare("SELECT * FROM tbl_playerprofile WHERE Squad_ID = ?");
        $stmtPlayers->execute([$squadID]);
        $players = $stmtPlayers->fetchAll(PDO::FETCH_ASSOC);

        // Fetch posts for the squad
        if (isset($_SESSION['user']['Squad_ID'])) {
            $squadID = $_SESSION['user']['Squad_ID'];
            // Fetch posts for the squad
            $stmtPosts = $pdo->prepare("SELECT * FROM tbl_squadposts WHERE Squad_ID = ? ORDER BY Timestamp DESC");
            $stmtPosts->execute([$squadID]);
            $posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $posts = []; // Handle no Squad_ID case
        }
    } 
    
} catch (PDOException $e) {
    // Handle database errors
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

// Replace the existing invite query with:
$stmt = $pdo->prepare("SELECT i.*, s.Squad_Name 
                      FROM tbl_inviteslog i
                      JOIN tbl_squadprofile s ON i.Challenger_Squad_ID = s.Squad_ID
                      WHERE i.Squad_ID = ?
                      ORDER BY i.Created_At DESC");
$stmt->execute([$_SESSION['user']['Squad_ID']]);
$invites = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $newInvitesCount = count(array_filter($invites, fn($invite) => $invite['Response'] === 'Pending'));

// // ADD THE NEW CODE RIGHT HERE:
$verificationNotifs = getVerificationNotifications($pdo, $_SESSION['user']['Squad_ID']);
$newInvitesCount = count(array_filter($invites, fn($invite) => $invite['Response'] === 'Pending'));
$verificationCount = count($verificationNotifs);
$totalNotifications = $newInvitesCount + $verificationCount;

// Replace your existing notification count code with:
    $verificationCount = count(array_filter($verificationNotifs, function($scrim) use ($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM tbl_matchverifications 
                              WHERE Match_ID = ? AND Squad_ID = ?");
        $stmt->execute([$scrim['Match_ID'], $_SESSION['user']['Squad_ID']]);
        return !$stmt->fetch();
    }));
    
    $totalNotifications = $newInvitesCount + $verificationCount;

// Add this near where you fetch the invites
$pendingInvitesCount = 0;
if (!empty($invites)) {
    $pendingInvitesCount = count(array_filter($invites, function($invite) {
        return $invite['Status'] === 'Pending';
    }));
}

// Add this near your other notification queries
function getVerificationNotifications($pdo, $squadID) {
    $currentTime = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("SELECT s.*, 
                          sp1.Squad_Name as Squad1_Name,
                          sp2.Squad_Name as Squad2_Name
                          FROM tbl_scrimslog s
                          JOIN tbl_squadprofile sp1 ON s.Squad1_ID = sp1.Squad_ID
                          JOIN tbl_squadprofile sp2 ON s.Squad2_ID = sp2.Squad_ID
                          WHERE (s.Squad1_ID = ? OR s.Squad2_ID = ?)
                          AND s.Scheduled_Time < ?
                          AND s.OCR_Validated = 0
                          AND s.Winner_Squad_ID IS NULL
                          ORDER BY s.Scheduled_Time DESC");
    $stmt->execute([$squadID, $squadID, $currentTime]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Usage:
$verificationNotifs = getVerificationNotifications($pdo, $_SESSION['user']['Squad_ID']);

// Get scrim details if coming from notification
$scrimDetails = [];
$opponentName = "Opponent Squad";
$matchSchedule = "N/A";
$numberOfGames = "N/A";

if (isset($_GET['scrim_id'])) {
    try {
        $scrimID = $_GET['scrim_id'];
        $stmt = $pdo->prepare("SELECT s.*, 
                              sp1.Squad_Name as Squad1_Name,
                              sp2.Squad_Name as Squad2_Name
                              FROM tbl_scrimslog s
                              JOIN tbl_squadprofile sp1 ON s.Squad1_ID = sp1.Squad_ID
                              JOIN tbl_squadprofile sp2 ON s.Squad2_ID = sp2.Squad_ID
                              WHERE s.Match_ID = ?");
        $stmt->execute([$scrimID]);
        $scrimDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($scrimDetails) {
            // Determine opponent name
            $opponentName = ($scrimDetails['Squad1_ID'] == $_SESSION['user']['Squad_ID']) 
                ? $scrimDetails['Squad2_Name'] 
                : $scrimDetails['Squad1_Name'];
            
            // Format match schedule
            $matchSchedule = date('F j, Y g:i A', strtotime($scrimDetails['Scheduled_Time']));
            
            // Get number of games (assuming this is stored in the scrim record)
            $numberOfGames = $scrimDetails['No_Of_Games'] ?? 'N/A';
        }
    } catch (PDOException $e) {
        // Handle error if needed
    }
}

// Calculate maximum possible score based on "best of" logic
$numberOfGames = isset($scrimDetails['No_Of_Games']) ? (int)$scrimDetails['No_Of_Games'] : 1;
$maxScore = ceil($numberOfGames / 2); // For BO3: ceil(3/2)=2, BO5: ceil(5/2)=3, etc.

// Calculate values for validation
$numberOfGames = isset($scrimDetails['No_Of_Games']) ? (int)$scrimDetails['No_Of_Games'] : 1;
$maxScore = ceil($numberOfGames / 2); // Maximum wins needed to win the series


// sledgehammer
// Function to count unread messages
function countUnreadMessages($pdo, $squadId) {
    $stmt = $pdo->prepare("SELECT SUM(
                            CASE 
                                WHEN Squad1_ID = ? THEN Squad1_Unread 
                                WHEN Squad2_ID = ? THEN Squad2_Unread 
                                ELSE 0 
                            END) as total_unread
                          FROM tbl_conversations
                          WHERE Squad1_ID = ? OR Squad2_ID = ?");
    $stmt->execute([$squadId, $squadId, $squadId, $squadId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_unread'] ?? 0;
}

// Get unread message count
$unreadMessageCount = countUnreadMessages($pdo, $_SESSION['user']['Squad_ID']);

// FIFTHHARMONY

// FOR MULTIPLE PROOF FILES
// Get verification with all proof files
$stmt = $pdo->prepare("SELECT v.*, p.File_Path 
                      FROM tbl_matchverifications v
                      LEFT JOIN tbl_prooffiles p ON v.Verification_ID = p.Verification_ID
                      WHERE v.Match_ID = ?");
$stmt->execute([$scrimID]);
$verificationData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="en">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5PJVHXE14X"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5PJVHXE14X');
</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Match Verification</title>
    <link rel="stylesheet" type="text/css" href="CSS/matchVerificationStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
</head>


<body class="customPageBackground">
    <div class="introScreen">
        <div class="loadingAnimation"></div>
    </div>


    <div class="pageContent hiddenContent">
        <!-- Navigation Bar -->
        <div class="container-fluid">        
            <div class="row">
                <div class="container-fluid navigationBar">
                    <!-- Logo Layer -->
                    <div class="logoLayer">
                        <!-- Logo and Name -->
                        <a class="navbar-brand" href="userHomepage.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                       
                        <!-- Search Bar -->
                        <form class="searchBar" action="searchResultsPage.php" method="GET">
                            <input class="searchInput" type="search" name="query" placeholder="Search Squads" aria-label="Search" disabled>
                            <button class="searchButton" type="submit" disabled>
                                <img src="IMG/essentials/whiteVer.PNG" alt="Search">
                            </button>
                        </form>
                   
                        <!-- Account Logo Button -->
                        <button class="accountLogo" data-bs-toggle="modal" data-bs-target="#loginSignupModal">
                            <i class="bi bi-person-circle"></i>
                        </button>                        
                   
                        <!-- Navbar Toggle Button -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                   
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="userHomepage.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="discoverPage.php">DISCOVER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="scrimsPage.php">SCRIMS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="invitesPage.php">MY INVITES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="invitesSentPage.php">SENT INVITES</a>
                        </li>
                        <!-- Icon Bars -->
                        <div class="iconsBar">
                            <!-- Notifications -->
                            <li class="nav-item">
                                <a class="nav-linkIcon" href="#" data-bs-toggle="modal" data-bs-target="#notificationModal">
                                    <i class="bi bi-app-indicator"></i>
                                    <?php if ($totalNotifications > 0): ?>
                                        <span class="notifCount"><?= $totalNotifications ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <!-- sledgehammer -->
                            <!-- Inbox -->
                            <li class="nav-item">
                                <a class="nav-linkIcon ju" href="inboxPage.php">
                                    <i class="bi bi-chat-left-fill"></i>
                                    <?php if ($unreadMessageCount > 0): ?>
                                        <span class="notifCount"><?= $unreadMessageCount ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Body -->
        <div class="container-fluid mainBody">
            <div class="uploadForm">
                <!-- Title -->
                <div class="row textBlockLeft">
                    <div class="descriptionLeft">
                        UPLOAD POST-MATCH SUMMARY TO
                    </div>
                    <div class="titleLeft">
                        VERIFY YOUR SCRIM
                    </div>
                    <div class="subtitleLeft">
                        AND EARN ABYSS POINTS!
                    </div>
                </div>

                <!-- Scrim Details -->
                <div class="row textBlockLeft">
                    <div class="descriptionLeft">
                        <span class="vs">VS</span> <?= htmlspecialchars($opponentName) ?>
                    </div>
                    <div class="descriptionLeft">
                        <span class="vs">SCHEDULE:</span> <?= htmlspecialchars($matchSchedule) ?>
                    </div>
                    <div class="descriptionLeft">
                        <span class="vs">NUMBER OF GAMES:</span> <?= htmlspecialchars($numberOfGames) ?>
                    </div>
                </div>

                <form action="includes/matchVerification.inc.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="scrim_id" value="<?= $_GET['scrim_id'] ?? '' ?>">
                    
                    <div class="row line">
                        <!-- Your Score -->
                        <div class="form-group mt-3 col-5">
                            <label class="form-label title">YOUR SCORE</label>
                            <input type="number" name="your_score" id="yourScore" class="form-control plchldr"
                                placeholder="Enter your score" min="0" max="<?= $maxScore ?>" required
                                oninput="validateScores()">
                        </div>

                        <!-- Opponent's Score -->
                        <div class="form-group mt-3 col-5">
                            <label class="form-label title"><?= htmlspecialchars($opponentName) ?>'S SCORE</label>
                            <input type="number" name="opponent_score" id="opponentScore" class="form-control plchldr"
                                placeholder="Enter <?= htmlspecialchars($opponentName) ?>'s score" min="0" max="<?= $maxScore ?>" required
                                oninput="validateScores()">
                        </div>

                        <!-- Hidden fields for validation -->
                        <input type="hidden" id="numberOfGames" value="<?= $numberOfGames ?>">
                        <input type="hidden" id="maxScore" value="<?= $maxScore ?>">

                        <!-- Error message display -->
                        <div class="row">
                            <div class="col-12">
                                <div id="scoreError" class="text-danger" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Change file input to accept multiple files -->
                    <div class="mb-3">
                        <label class="form-label">ATTACH FILES (Multiple allowed)</label>
                        <div class="custom-file-upload">
                            <input type="file" name="proof_files[]" id="fileInput" hidden multiple required>
                            <button type="button" class="modalButtons" onclick="document.getElementById('fileInput').click()">
                                CHOOSE FILES
                            </button>
                            <span class="fileName" id="fileName">No files chosen</span>
                        </div>
                    </div>

                    <div class="proof-files">
                        <?php foreach ($verificationData as $file): ?>
                            <?php if (!empty($file['File_Path'])): ?>
                                <a href="<?= $file['File_Path'] ?>" target="_blank">
                                    <img src="<?= $file['File_Path'] ?>" class="proof-thumbnail">
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                                                
                    <!-- Verify Button -->
                    <div class="verifyButton">
                        <button type="submit" name="verify_submit" class="btn loginButton" id="verifyButton">VERIFY SCRIM MATCH</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Advertisment -->
        <div class="container">
            <div class="row d-flex advertisement">
                <a href="https://play.google.com/store/apps/details?id=com.hhgame.mlbbvn&hl=en-US&pli=1">
                    <img src="IMG/essentials/advertisement.png" class="adIMG" alt="advertissement">
                </a>
            </div>
        </div>


        <!-- Decorative Divider-->
        <div class="container-fluid">
            <div class="row divider">
                <div class="decoDivide">
                    <div class="decoBox"></div>
                    <div class="codeDeco">0905270     //</div>
                    <div class="decoLine"></div>  
                    <div class="decoFoxDivide">
                        <div class="glowingFox"></div>
                    </div>
                </div>
            </div>
        </div>
       
        <footer>
            <div class="row">
                <div class="col-12">
                    <div class="about-us">
                        <div class="aboutUsTop">
                            Welcome to abyss, a student-developed initiative from Lyceum of Subic Bay, created to revolutionize Mobile Legends scrimmage matchmaking. As passionate IT students and gamers, we recognized the challenges squads face in finding, organizing, and managing scrims efficiently. Our goal is to provide a faster, more centralized platform where teams can seamlessly connect, compete, and improve their gameplay.
                        </div>


                        <div class="aboutUsBot">
                            With a user-friendly system, we aim to eliminate the hassle of manual scheduling and random opponent searches. Whether you're a casual team looking for practice or a competitive squad aiming for the top, abyss makes scrimmage organized, fair, and accessible. Join us in reshaping the competitive scene — where squads battle, strategies evolve, and legends are made!
                            <br><br>
                            © FEBRUARY 2025
                        </div>
                    </div>  


                    <div class="socialMediaIcons">
                        <i class="bi bi-facebook"></i>
                        <i class="bi bi-twitter-x"></i>
                        <i class="bi bi-instagram"></i>
                    </div>


                    <div class="footIcon">
                        <a class="navbar-brand" href="index.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                    </div>
                </div>                  
            </div>
        </footer>
    </div>
    
    
    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="squadVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-end">
            <div class="modal-content customModal" style="height: 100vh;">
                <div class="modal-header">
                    <h5 class="modal-title" id="squadVerificationModalLabel">NOTIFICATIONS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($invites)): ?>
                        <?php foreach ($invites as $invite): ?>
                            <div class="notification <?= $invite['Response'] === 'Pending' ? 'new' : '' ?>" data-invite-id="<?= $invite['Schedule_ID'] ?>">
                                <div class="time">
                                    <?= date('n/j/Y g:i', strtotime($invite['Created_At'])) ?>
                                </div>
                                <strong><?= htmlspecialchars($invite['Squad_Name']) ?></strong> invites you to a scrim match!
                                <div class="scrim-cardOnNotif">
                                    <div class="scrim-card-contentOnNotif">
                                        <div class="scrimButtons">
                                            <?php if ($invite['Response'] === 'Pending'): ?>
                                                <!-- Interactive buttons for pending invites -->
                                                <button class="acceptOnNotif" onclick="respondToInvite(<?= $invite['Schedule_ID'] ?>, 'Accepted')">
                                                    ACCEPT
                                                </button>
                                                <button class="declineOnNotif" onclick="respondToInvite(<?= $invite['Schedule_ID'] ?>, 'Declined')">
                                                    DECLINE
                                                </button>
                                            <?php else: ?>
                                                <!-- Non-clickable status for responded invites -->
                                                <button class="<?= $invite['Response'] === 'Accepted' ? 'acceptedOnNotif' : 'declinedOnNotif' ?>" disabled>
                                                    <?= strtoupper($invite['Response']) ?>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Opponent Squad Name -->
                                        <div class="opponentOnNotif">
                                            <div class="squadNameOnNotif">
                                                <span class="vs">VS</span> <strong><?= htmlspecialchars($invite['Squad_Name']) ?></strong>
                                            </div>
                                        </div>

                                        <!-- Scrim Notes (if available) -->
                                        <?php if (!empty($invite['Scrim_Notes'])): ?>
                                            <div class="noGamesOnNotif">
                                                <?= htmlspecialchars($invite['Scrim_Notes']) ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Date and Time -->
                                        <div class="timeAndDateOnNotif">
                                            <!-- Time -->
                                            <div class="TimeOnNotif">
                                                <?= date('g:i A', strtotime($invite['Scrim_Time'])) ?>
                                            </div>
                                            <!-- Date -->
                                            <div class="DateOnNotif">
                                                <?= date('Y-m-d', strtotime($invite['Scrim_Date'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>     

                    <!-- Verification Automated Message -->
                    <?php foreach ($verificationNotifs as $scrim): ?>
                        <div class="notification new" data-scrim-id="<?= $scrim['Match_ID'] ?>">
                            <div class="time">
                                <?= date('n/j/Y g:i', strtotime($scrim['Scheduled_Time'])) ?>
                            </div>
                            <strong>Scrim match finished!</strong> Time to verify and earn Abyss Points!
                            <div class="scrim-cardOnNotif">
                                <div class="scrim-card-contentOnNotif">
                                    <!-- Single Verify Button -->
                                    <div class="scrimButtons">
                                        <a href="matchVerificationPage.php">
                                            <button class="verifyOnNotif">
                                                VERIFY
                                            </button>
                                        </a>
                                    </div>
                                    
                                    <!-- Opponent Info -->
                                    <div class="opponentOnNotif">
                                        <div class="squadNameOnNotif">
                                            <span>VS</span> <strong>
                                                <?= htmlspecialchars($scrim['Squad1_ID'] == $_SESSION['user']['Squad_ID'] 
                                                    ? $scrim['Squad2_Name'] 
                                                    : $scrim['Squad1_Name']) ?>
                                            </strong>
                                        </div>
                                    </div>
                                    
                                    <!-- Scheduled Time -->
                                    <div class="timeAndDateOnNotif">
                                        <div class="TimeOnNotif">
                                            <?= date('g:i A', strtotime($scrim['Scheduled_Time'])) ?>
                                        </div>
                                        <div class="DateOnNotif">
                                            <?= date('Y-m-d', strtotime($scrim['Scheduled_Time'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($invites) && empty($verificationNotifs)): ?>
                        <div class="notification">
                            <div class="noNotifications">No new notifications</div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="notifEnd">End of Feed</div>
                </div>                        
            </div>
        </div>
    </div>

    <!-- POP UP MODAL TRY FOR OCR ERROR -->
    <?php if (isset($_SESSION['ocr_mismatch']) && $_SESSION['ocr_mismatch']): ?>
        <div id="ocrModal" class="modal-overlay">
            <div class="modal-content text-white">
                <?= $_SESSION['debug'] ?? '' ?>
                <?= $_SESSION['debug2'] ?? '' ?>
                <?= $_SESSION['debug3'] ?? '' ?>
                <h2>❌ OCR Mismatch Detected</h2>
                <p>The number of scanned “Victory” and “Defeat” results does not match the scores you entered.</p>
                <button onclick="closeModal()">OK, I’ll fix it</button>
            </div>
        </div>
        <script>
            function closeModal() {
                document.getElementById('ocrModal').style.display = 'none';
            }
            window.onload = () => document.getElementById('ocrModal').style.display = 'flex';
        </script>
        <style>
            .modal-overlay {
                display: none;
                position: fixed;
                z-index: 1000;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(0, 0, 0, 0.7);
                justify-content: center;
                align-items: center;
            }
            .modal-content {
                background: #fff;
                padding: 25px 30px;
                border-radius: 8px;
                text-align: center;
                font-family: 'Segoe UI', sans-serif;
                max-width: 400px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            }
            .modal-content button {
                margin-top: 20px;
                background-color: #b30000;
                border: none;
                color: white;
                padding: 10px 20px;
                border-radius: 4px;
                font-size: 16px;
                cursor: pointer;
            }
        </style>
        <?php unset($_SESSION['ocr_mismatch']); ?>
    <?php endif; ?>

    <!-- Javascript -->
    <script>
    // Convert PHP variables to JS
    const verificationStatus = <?= json_encode($verificationStatus) ?>;
    const squadLevel = <?= json_encode($squadDetails['Squad_Level']) ?>;
    </script>
    <script src="JS/matchVerificationScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    
</body>
</html>
