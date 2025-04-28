<?php
session_start();
require_once 'includes/dbh.inc.php';

// Get Squad_ID from URL
$squadID = $_GET['id'] ?? null;

if (!$squadID) {
    header("Location: discoverPage.php");
    exit();
}

// Fetch squad details
try {
    $stmt = $pdo->prepare("SELECT * FROM tbl_squadprofile WHERE Squad_ID = ?");
    $stmt->execute([$squadID]);
    $squadDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$squadDetails) {
        header("Location: discoverPage.php");
        exit();
    }

    // Fetch players
    $stmtPlayers = $pdo->prepare("SELECT * FROM tbl_playerprofile WHERE Squad_ID = ?");
    $stmtPlayers->execute([$squadID]);
    $players = $stmtPlayers->fetchAll(PDO::FETCH_ASSOC);

    // Fetch public posts only
    $stmtPosts = $pdo->prepare("SELECT * FROM tbl_squadposts WHERE Squad_ID = ? AND Post_Type = 'public' ORDER BY Timestamp DESC");
    $stmtPosts->execute([$squadID]);
    $posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle error
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

// Hero check
$heroPaths = [];
try {
    $heroQuery = "SELECT Hero_Name, Path FROM tbl_heroimages";
    $heroStmt = $pdo->query($heroQuery);
    $heroPaths = $heroStmt->fetchAll(PDO::FETCH_KEY_PAIR); // Creates [Hero_Name => Path]
} catch (PDOException $e) {
    // Handle error if needed
    die("Error fetching hero data: " . $e->getMessage());
}

$verificationStatus = 'Pending';
if (isset($_SESSION['user']['Squad_ID']) && !empty($_SESSION['user']['Squad_ID'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM tbl_verificationrequests WHERE Squad_ID = ? ORDER BY Date_Submitted DESC LIMIT 1");
        $stmt->execute([$_SESSION['user']['Squad_ID']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $verificationStatus = $result['Status'] ?? 'Not Submitted';
        $verificationLevel = $result['Squad_Level'] ?? 'Amateur';
    } catch (PDOException $e) {
        // Handle error if needed
    }
}

// Fetch logged-in user's squad level NEWNEWNEWNEW
$userSquadLevel = 'N/A';
if (isset($_SESSION['user']['Squad_ID']) && $_SESSION['user']['Squad_ID'] !== 'N/A') {
    try {
        $stmtUserSquad = $pdo->prepare("SELECT Squad_Level FROM tbl_squadprofile WHERE Squad_ID = ?");
        $stmtUserSquad->execute([$_SESSION['user']['Squad_ID']]);
        $userSquadData = $stmtUserSquad->fetch(PDO::FETCH_ASSOC);
        if ($userSquadData) {
            $userSquadLevel = $userSquadData['Squad_Level'];
        }
    } catch (PDOException $e) {
        // Handle error if needed
    }
}

// Replace the existing verification check with this
$enableScrimButton = ($verificationStatus === 'Approved') || (strcasecmp($userSquadLevel, 'Amateur') === 0);

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

// try {
//     // Fetch ALL user data from the database using session username TESTING TESTING
//     if (isset($_SESSION['user']['username'])) {
//         $query = "SELECT * FROM tbl_useraccount WHERE Username = :username";
//         $stmt = $pdo->prepare($query);
//         $stmt->bindParam(":username", $_SESSION['user']['username'], PDO::PARAM_STR);
//         $stmt->execute();
//         $user_data = $stmt->fetch(PDO::FETCH_ASSOC);


//         if ($user_data) {
//             // Update session with latest data (including Squad_ID)
//             $_SESSION['user'] = $user_data;
//             $user = $user_data; // For direct use in HTML
//         }
//     }


//     // Fetch squad details if Squad_ID is set
//     if (isset($_SESSION['user']['Squad_ID'])) {
//         $squadID = $_SESSION['user']['Squad_ID'];

//         // Fetch squad details
//         $stmtSquad = $pdo->prepare("SELECT Squad_Acronym, Squad_Name, Squad_ID, Squad_Level, Squad_Description FROM tbl_squadprofile WHERE Squad_ID = ?");
//         $stmtSquad->execute([$squadID]);
//         $squadDetails = $stmtSquad->fetch(PDO::FETCH_ASSOC);


//         // If no squad is found, set default values
//         if (!$squadDetails) {
//             $squadDetails = [
//                 'Squad_Acronym' => 'N/A',
//                 'Squad_Name' => 'N/A',
//                 'Squad_ID' => 'N/A',
//                 'Squad_Level' => 'N/A',
//                 'Squad_Description' => 'N/A'
//             ];
//         }


//         // Update session with the latest squad details
//         $_SESSION['squad_details'] = $squadDetails;


//         // Fetch players for the squad
//         $stmtPlayers = $pdo->prepare("SELECT * FROM tbl_playerprofile WHERE Squad_ID = ?");
//         $stmtPlayers->execute([$squadID]);
//         $players = $stmtPlayers->fetchAll(PDO::FETCH_ASSOC);

//         // Fetch posts for the squad
//         if (isset($_SESSION['user']['Squad_ID'])) {
//             $squadID = $_SESSION['user']['Squad_ID'];
//             // Fetch posts for the squad
//             $stmtPosts = $pdo->prepare("SELECT * FROM tbl_squadposts WHERE Squad_ID = ? ORDER BY Timestamp DESC");
//             $stmtPosts->execute([$squadID]);
//             $posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);
//         } else {
//             $posts = []; // Handle no Squad_ID case
//         }
//     } 
    
// } catch (PDOException $e) {
//     // Handle database errors
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

// Fetch leaderboard data
$leaderboard = [];
$squadRank = null;

try {
    $stmtLeaderboard = $pdo->query("SELECT Squad_ID, Squad_Name, ABYSS_Score 
                                    FROM tbl_squadprofile 
                                    ORDER BY ABYSS_Score DESC 
                                    LIMIT 10"); // Fetch top 10 squads
    $leaderboard = $stmtLeaderboard->fetchAll(PDO::FETCH_ASSOC);

    // Determine the rank of the searched squad
    foreach ($leaderboard as $index => $squad) {
        if ((string)$squad['Squad_ID'] === (string)$squadID) {
            $squadRank = $index + 1; // Rank is index + 1 (1-based)
            break;
        }
    }
} catch (PDOException $e) {
    // Handle error silently
    die("Error fetching leaderboard: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Search Results</title>
    <link rel="stylesheet" type="text/css" href="CSS/squadDetailsStyle.css">
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

        <!-- Squad Details (view-only version) -->
        <div class="squadDetails">
            <div class="squadDetailsContent">
                <div class="buttons">
                <a href="feedbacksPage.php?receiver_id=<?= $squadDetails['Squad_ID'] ?>" class="feedbackButton">FEEDBACK</a>
                    <a href="reportsPage.php?reported_id=<?= $squadDetails['Squad_ID'] ?>" class="reportButton">REPORT</a>
                </div>
                <div class="row squadAccount">
                    <div class="squadAcronym">
                        <?= htmlspecialchars($squadDetails['Squad_Acronym']) ?>
                    </div>
                    <div class="squadName">
                        <?= htmlspecialchars($squadDetails['Squad_Name']) ?>
                    </div>
                    <div class="squadAccountID">
                        ID: <?= htmlspecialchars($squadDetails['Squad_ID']) ?>
                    </div>
                    <div class="tabsRow">
                        <?php if ($squadRank !== null && $squadRank <= 3): ?>
                            <div class="tabs">Top <?= $squadRank ?> Global Squad</div>
                        <?php endif; ?>
                        <div class="tabs"><?= htmlspecialchars($squadDetails['Squad_Level']) ?></div>
                    </div>
                    <div class="squadDescription">
                        <?= htmlspecialchars($squadDetails['Squad_Description']) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Body (view-only) -->
        <div class="row mainBody">
        <button onclick="openChallengeModal(<?= $squadDetails['Squad_ID'] ?>)" 
                class="challengeButton <?= !$enableScrimButton ? 'disabled' : '' ?>" 
                <?= !$enableScrimButton ? 'disabled' : '' ?>>
            CHALLENGE
        </button>
                                        
            <!-- Stats Column -->
            <div class="col-3" >
                <div class="squadStatistics">SQUAD STATISTICS</div>
                <div class="squadStats">
                    <div class="winRate">
                        <div class="statsContent">
                            <div class="number">88%</div>
                        <div class="statsLabel">WIN RATE</div>
                        </div>
                    </div>


                    <div class="winRate">
                        <div class="statsContent">
                            <div class="number">245</div>
                        <div class="statsLabel">MATCHES</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Feed (posts only, no post form) -->
            <div class="col-6">
                <div class="feed post">
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <!-- Same post display as before -->
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="end">This squad has no public posts.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pagination Controls Button -->
            <div class="scrim-pagination pagination-controls">
                <button id="prevPage" class="page-btn prev-btn pagination-button" disabled>Previous</button>
                <span id="pageInfo" class="page-indicator">Page 1</span>
                <button id="nextPage" class="page-btn next-btn pagination-button">Next</button>
            </div>

            <!-- Players Column -->
            <div class="col-3" >
                <div class="squadPlayers">
                    <?php foreach ($players as $player): ?>
                        <div class="playerProfile">
                            <div class="heroCircles">
                                <?php foreach (['Hero_1', 'Hero_2', 'Hero_3'] as $heroField): ?>
                                    <?php
                                    $heroName = $player[$heroField] ?? '';
                                    $heroImage = $heroName ? ($heroPaths[$heroName] ?? '') : '';
                                    ?>
                                    <img src="<?= $heroImage ?>" class="hero-icon" alt="<?= $heroName ?>" title="<?= $heroName ?>">
                                <?php endforeach; ?>
                            </div>

                            <div class="IGNs">
                                <div class="IGN"><?= htmlspecialchars($player['IGN']) ?></div>
                                <div class="role"><?= htmlspecialchars($player['Role']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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

    <!-- Challenge Modal -->
    <div class="modal fade" id="challengeModal" tabindex="-1" aria-labelledby="challengeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content customModal">
                <div class="modal-header">
                    <h5 class="modal-title" id="challengeModalLabel">SCHEDULE SCRIM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for scrim schedule details -->
                    <form id="scrimScheduleForm">
                        <div class="mb-3">
                            <label for="scrimDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="scrimDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="scrimTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="scrimTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="scrimNotes" class="form-label">Number of Games</label>
                            <select class="form-control" id="scrimNotes" required>
                                <option value="" disabled selected>Select number of games</option>
                                <option value="1">1 Game</option>
                                <option value="3">Best of 3</option>
                                <option value="5">Best of 5</option>
                                <option value="7">Best of 7</option>
                            </select>
                        </div>
                        <div class="mb-3 custom-games-input" style="display: none;">
                            <label for="customGames" class="form-label">Custom Number</label>
                            <input type="number" class="form-control" id="customGames" min="1" max="99">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modalButtons" data-bs-dismiss="modal">CLOSE</button>
                    <button type="button" class="modalButtons" onclick="submitScrimSchedule()">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Javascript -->
    <script>
    // Convert PHP variables to JS
    const verificationStatus = <?= json_encode($verificationStatus) ?>;
    const squadLevel = <?= json_encode($userSquadLevel) ?>;

    // Pagination
    document.addEventListener('DOMContentLoaded', function () {
        const postsPerPage = 10;
        let currentPage = 1;
        const posts = document.querySelectorAll('.post');
        const totalPages = Math.ceil(posts.length / postsPerPage);
        const prevButton = document.getElementById('prevPage');
        const nextButton = document.getElementById('nextPage');
        const pageInfo = document.getElementById('pageInfo');

        function showPage(page) {
            posts.forEach((post, index) => {
                post.style.display = (index >= (page - 1) * postsPerPage && index < page * postsPerPage) ? 'block' : 'none';
            });
            pageInfo.textContent = `Page ${page}`;
            prevButton.disabled = page === 1;
            nextButton.disabled = page === totalPages;
        }

        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        // Initialize the first page
        showPage(currentPage);
    });
    </script>
    <script src="JS/squadDetailsScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>