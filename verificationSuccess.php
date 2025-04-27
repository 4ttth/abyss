<?php
session_start();
require_once '/includes/dbh.inc.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Check if this is a valid redirect from verification submission
if (!isset($_SESSION['verification_submitted'])) {
    header("Location: discoverPage.php?error=invalid_verification");
    exit();
}

// Clear the verification submission flag
unset($_SESSION['verification_submitted']);

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

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Verification Received</title>
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

        <!-- Main Body with success content -->
        <div class="container-fluid mainBody">
            <div class="uploadForm">
                <!-- Title Block Left -->
                <div class="row textBlockLeft">
                    <div class="titleLeft">
                        VERIFICATION RECEIVED
                    </div>
                    <div class="subtitleLeft">
                        Your verification request has been submitted. Please wait patiently.
                    </div>
                </div>

                <!-- Success Message Content -->
                <div class="row line">
                    <div class="form-group mt-3 col-12">
                        <div class="success-message">
                            <div class="verification-status">
                                <div class="status-icon">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                            </div>
                            <div class="success-actions">
                                <a href="userHomepage.php" class="btn loginButton">RETURN HOME</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advertisment -->
        <div class="container">
            <div class="row d-flex advertisement">
                <a href="https://play.google.com/store/apps/details?id=com.hhgame.mlbbvn&hl=en-US&pli=1">
                    <img src="IMG/essentials/advertisement.png" class="adIMG" alt="advertisement">
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
                            Welcome to abyss, a student-developed initiative from Lyceum of Subic Bay...
                        </div>
                        <div class="aboutUsBot">
                            With a user-friendly system, we aim to eliminate the hassle...
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
        <!-- ... (same as your reports page) ... -->
    </div>

    <!-- Javascript -->
    <script src="JS/matchVerificationScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>