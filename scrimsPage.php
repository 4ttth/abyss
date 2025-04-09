<?php
session_start(); // Essential for maintaining user session
require_once 'includes/dbh.inc.php'; // Database connection (same as homepage)


// Initialize user data from session (same as homepage)
$user = $_SESSION['user'] ?? ['username' => 'Guest', 'Squad_ID' => 'N/A'];


// Initialize squad details if needed (similar to homepage)
$squadDetails = $_SESSION['squad_details'] ?? [
    'Squad_Acronym' => 'N/A',
    'Squad_Name' => 'N/A',
    'Squad_ID' => 'N/A',
    'Squad_Level' => 'N/A'
];


// try {
//     // Verify user has a squad (optional - depends on your requirements)
//     if (isset($_SESSION['user']['Squad_ID'])) {
//         $squadID = $_SESSION['user']['Squad_ID'];
       
//         // Add any scrim-specific queries here
//         // For example:
//         $stmtScrims = $pdo->prepare("SELECT * FROM tbl_scrimslog WHERE Squad_ID = ? OR Opponent_ID = ? ORDER BY Scrim_Date DESC");
//         $stmtScrims->execute([$squadID, $squadID]);
//         $scrims = $stmtScrims->fetchAll(PDO::FETCH_ASSOC);
       
//         // Or to find available scrims:
//         $stmtAvailable = $pdo->prepare("SELECT * FROM tbl_scrimslog WHERE Status = 'Looking' AND Squad_ID != ?");
//         $stmtAvailable->execute([$squadID]);
//         $availableScrims = $stmtAvailable->fetchAll(PDO::FETCH_ASSOC);
//     }


// } catch (PDOException $e) {
//     die("Database error: " . htmlspecialchars($e->getMessage()));
// }


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

// Fetch scrims for the logged-in squad
$scrims = [];
if (isset($_SESSION['user']['Squad_ID'])) {
    $squadID = $_SESSION['user']['Squad_ID'];
    
    $stmt = $pdo->prepare("SELECT s.*, 
    sp1.Squad_Name as Squad1_Name,
    sp2.Squad_Name as Squad2_Name,
    CASE 
        WHEN s.Winner_Squad_ID IS NULL THEN 'Upcoming'
        WHEN s.Winner_Squad_ID = ? THEN 'Victory'
        ELSE 'Defeat'
    END as ResultStatus
    FROM tbl_scrimslog s
    JOIN tbl_squadprofile sp1 ON s.Squad1_ID = sp1.Squad_ID
    JOIN tbl_squadprofile sp2 ON s.Squad2_ID = sp2.Squad_ID
    WHERE s.Squad1_ID = ? OR s.Squad2_ID = ?
    ORDER BY s.Scheduled_Time DESC");

    // Execute with array of values
    $stmt->execute([$squadID, $squadID, $squadID]);
    $scrims = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Scrims</title>
    <link rel="stylesheet" type="text/css" href="CSS/scrimsStyle.css">
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
                            <input class="searchInput" type="search" name="query" placeholder="Search Squads" aria-label="Search">
                            <button class="searchButton" type="submit">
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
                            <a class="nav-link active" href="scrimsPage.php">SCRIMS</a>
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
                            <!-- Inbox -->
                            <li class="nav-item">
                                <a class="nav-linkIcon ju" href="inboxPage.php">
                                    <i class="bi bi-chat-left-fill"></i>
                                    <span class="notifCount">3</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Main Body -->
        <div class="mainBody">
            <div class="filter">
                <div class="scrim-filter-dropdown">
                    <button class="btn dropdown-toggle scrimFilter" type="button" id="scrimFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>All Scrims</span>
                    </button>
                    <ul class="dropdown-menu scrimFilterDropdown" aria-labelledby="scrimFilterDropdown">
                        <li><a class="dropdown-item filter-option active" href="#" data-status="all">All Scrims</a></li>
                        <li><a class="dropdown-item filter-option" href="#" data-status="upcoming">Upcoming</a></li>
                        <li><a class="dropdown-item filter-option" href="#" data-status="victory">Victories</a></li>
                        <li><a class="dropdown-item filter-option" href="#" data-status="defeat">Defeats</a></li>
                        <li><a class="dropdown-item filter-option" href="#" data-status="unverified">Unverified</a></li>
                        <li><a class="dropdown-item filter-option" href="#" data-status="pendingVerification">Pending</a></li>
                    </ul>
                </div>
            </div>


            <!-- Result -->
            <div class="results">
                <div class="scrims-container">
                    <!-- Scrim Cards Grid -->
                    <div class="scrims-grid" id="scrimsGrid">    
                        <div class="scrims-grid-container" id="scrimsContainer">
                            <?php foreach ($scrims as $scrim): ?>
                                <?php 
                                // Determine card status
                                $statusClass = '';
                                $currentTime = time();
                                $scheduledTime = strtotime($scrim['Scheduled_Time']);

                                // Four possible statuses:
                                // 1. OCR Validated (with winner/loser status)
                                // 2. Pending Verification (submitted but not validated)
                                // 3. Needs Verification (past due but not submitted)
                                // 4. Upcoming (not yet occurred)

                                if ($scrim['OCR_Validated'] == 1) {
                                    // Case 1: Results are fully validated
                                    if ($scrim['Winner_Squad_ID'] == $_SESSION['user']['Squad_ID']) {
                                        $statusClass = 'victory';
                                    } else {
                                        $statusClass = 'defeat';
                                    }
                                } elseif ($scrim['Verification_Submitted'] == 1 && $scrim['OCR_Validated'] == 0) {
                                    // Case 2: Verification submitted but not yet validated
                                    $statusClass = 'pendingVerification';
                                } elseif (time() > $scheduledTime) {
                                    // Case 3: Match is past due but no verification submitted
                                    $statusClass = 'unverified';
                                } else {
                                    // Case 4: Match hasn't happened yet
                                    $statusClass = 'upcoming';
                                }
                                ?>
                                
                                <div class="scrim-card" data-status="<?= strtolower($statusClass) ?>">
                                    <div class="scrim-card-content">
                                        <!-- Status -->
                                        <div class="status <?= $statusClass ?>">
                                            <?php 
                                                switch($statusClass) {
                                                    case 'victory': 
                                                        echo 'VICTORY'; 
                                                        break;
                                                    case 'defeat': 
                                                        echo 'DEFEAT'; 
                                                        break;
                                                    case 'pendingVerification': 
                                                        echo 'PENDING VERIFICATION';  // Display with space
                                                        break;
                                                    case 'unverified': 
                                                        echo 'UNVERIFIED'; 
                                                        break;
                                                    case 'upcoming': 
                                                        echo 'UPCOMING'; 
                                                        break;
                                                }
                                            ?>
                                        </div>
                                        
                                        <!-- Score -->
                                        <div class="score">
                                            <div class="yourScore">
                                                <?= ($scrim['Squad2_ID'] == $_SESSION['user']['Squad_ID'] ? $scrim['Winner_Score'] ?? '' : $scrim['Loser_Score'] ?? '') ?>
                                            </div>
                                            <div class="dash">-</div>
                                            <div class="theirScore">
                                                <?= ($scrim['Squad1_ID'] == $_SESSION['user']['Squad_ID'] ? $scrim['Winner_Score'] ?? '' : $scrim['Loser_Score'] ?? '') ?>
                                            </div>
                                        </div>
                                        
                                        <!-- Opponent -->
                                        <div class="opponent">
                                            <div class="squadName">
                                                VS <?= htmlspecialchars($scrim['Squad1_ID'] == $_SESSION['user']['Squad_ID'] ? $scrim['Squad2_Name'] : $scrim['Squad1_Name']) ?>
                                            </div>
                                        </div>
                                        
                                        <!-- Number of Games -->
                                        <div class="noGames">
                                            BEST OF <?= ($scrim['Winner_Score'] + $scrim['Loser_Score']) ?? '3' ?>
                                        </div>
                                        
                                        <!-- Scheduled Time -->
                                        <div class="timeAndDate">
                                            <div class="Time">
                                                <?= date('g:i A', strtotime($scrim['Scheduled_Time'])) ?>
                                            </div>
                                            <div class="Date">
                                                <?= date('Y-m-d', strtotime($scrim['Scheduled_Time'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                    <!-- Pagination Controls Bottom -->
                    <div class="scrim-pagination">
                        <button class="page-btn prev-btn" disabled>Previous</button>
                        <span class="page-indicator">Page 1 of 3</span>
                        <button class="page-btn next-btn">Next</button>
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
                                        <?php if (!empty($invite['No_Of_Games'])): ?>
                                            <div class="noGamesOnNotif">
                                                BEST OF <?= htmlspecialchars($invite['No_Of_Games']) ?>
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
                    <?php foreach ($verificationNotifs as $scrim): 
                        // Check if verification was already submitted
                        $stmt = $pdo->prepare("SELECT * FROM tbl_matchverifications 
                                            WHERE Match_ID = ? AND Squad_ID = ?");
                        $stmt->execute([$scrim['Match_ID'], $_SESSION['user']['Squad_ID']]);
                        $verificationSubmitted = $stmt->fetch();
                    ?>

                        <div class="notification <?= $verificationSubmitted ? '' : 'new' ?>" data-scrim-id="<?= $scrim['Match_ID'] ?>">
                            <div class="time">
                                <?= date('n/j/Y g:i', strtotime($scrim['Scheduled_Time'])) ?>
                            </div>
                            <strong>Scrim match finished!</strong> Time to verify and earn Abyss Points!
                            <div class="scrim-cardOnNotif">
                                <div class="scrim-card-contentOnNotif">
                                    <!-- Single Verify Button -->
                                    <div class="scrimButtons">
                                        <?php if ($verificationSubmitted): ?>
                                            <button class="pendingOnNotif" disabled>
                                                PENDING
                                            </button>
                                        <?php else: ?>
                                            <a href="matchVerificationPage.php?scrim_id=<?= $scrim['Match_ID'] ?>">
                                                <button class="verifyOnNotif">
                                                    VERIFY
                                                </button>
                                            </a>
                                        <?php endif; ?>
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

    <!-- Javascript -->
    <script src="JS/scrimsScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>