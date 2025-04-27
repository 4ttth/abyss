<?php
session_start();
require_once 'includes/dbh.inc.php';

if (!in_array($_SESSION['user']['Role'], ['Admin'])) {
    header("Location: /loginPage.php");
    exit("Access Denied!");
}

// Get counts from database
try {
    // Pending Reports
    $stmt = $pdo->query("SELECT COUNT(*) FROM tbl_reports WHERE Report_Status = 'Pending'");
    $reportCount = $stmt->fetchColumn();

    // Pending Verification Requests
    $stmt = $pdo->query("SELECT COUNT(*) FROM tbl_verificationrequests WHERE Status = 'Pending'");
    $requestCount = $stmt->fetchColumn();

    // Total Users (Players)
    $stmt = $pdo->query("SELECT COUNT(*) FROM tbl_useraccount WHERE Role = 'User'");
    $userCount = $stmt->fetchColumn();
    

    // SOMETHING DOESNT WORK WHEN I ADD THIS
    // Active Squads (members logged in within 30 days)
    $stmt = $pdo->query("SELECT COUNT(DISTINCT u.Squad_ID) 
    FROM tbl_useraccount u
    JOIN tbl_userlogin l ON u.User_ID = l.User_ID
    WHERE l.Login_Time >= NOW() - INTERVAL 30 DAY AND u.Role = 'User'");
    $activeSquads = $stmt->fetchColumn();

    // Inactive Squads
    $stmt = $pdo->query("SELECT COUNT(DISTINCT u.Squad_ID) 
    FROM tbl_useraccount u
    WHERE u.Role = 'User' AND u.Squad_ID NOT IN (
        SELECT DISTINCT u2.Squad_ID 
        FROM tbl_useraccount u2
        JOIN tbl_userlogin l ON u2.User_ID = l.User_ID
        WHERE l.Login_Time >= NOW() - INTERVAL 30 DAY AND u2.Role = 'User'
    )");
    $inactiveSquads = $stmt->fetchColumn();

    // Squads on Timeout
    $stmt = $pdo->query("SELECT COUNT(DISTINCT Squad_ID) 
    FROM tbl_penalties 
    WHERE Status = 'Active' 
    AND Penalty_Type = 'Timeout'");
    $timeoutSquads = $stmt->fetchColumn();
    
} catch (PDOException $e) {
    // Handle error
    die("Database error: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Moderator</title>
    <link rel="stylesheet" type="text/css" href="CSS/modMyStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
</head>

<body>
    <!-- Loading Screen for Landing Page -->
    <div class="introScreen">
        <div class="loadingAnimation"></div>
    </div>

    <div class="pageContent hiddenContent">
        <!-- Vertical Navigation Bar (modified from original) -->
        <div class="container-fluid navigationBar vertical-nav">
            <!-- Logo Layer -->
            <div class="logoLayer">
                <a class="navbar-brand" href="index.php">
                    <div class="logo-stack">
                        <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                        <div class="logoText">abyss</div>
                    </div>
                </a>
            </div>
           
            <!-- Vertical Nav Links -->
            <div class="navBarOverflow">
                <ul class="nav flex-column">
                    <li class="nav-item firstItem">
                        <a class="nav-link" href="/adminIndex.php">
                            HOME
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/adminContentManagement.php">
                            <span class="nav-text">EVENT MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/adminInstructionsManagement.php">
                            <span class="nav-text">INSTRUCTION MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/adminModeratorAccounts.php">
                            <span class="nav-text">MODERATOR ACCOUNTS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Moderator Functions/modSquadAccounts.php">
                            <span class="nav-text">SQUAD ACCOUNTS</span>
                        </a>
                    </li>
                    <!-- Moderator Priivileges -->
                    <li class="nav-item">
                    <a class="nav-link active" href="/Moderator Functions/modIndex.php">
                            <span class="nav-text">MODERATOR INDEX</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Moderator Functions/modReports.php">
                            REPORTS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Moderator Functions/modFeedbacks.php">
                            FEEDBACKS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Moderator Functions/modRequests.php">
                            <span class="nav-text">VERIFICATION REQUESTS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Moderator Functions/modScrimsLog.php">
                            <span class="nav-text">SCRIMS LOG</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Moderator Functions/modInvitesLog.php">
                            <span class="nav-text">INVITES LOG</span>
                        </a>
                    </li>
                </ul>
            </div>
           
            <!-- Account Logo (at bottom) -->
            <div class="nav-footer">
                <form action="includes/logout.inc.php" method="post">
                    <button class="accountLogo" data-bs-toggle="modal" data-bs-target="#loginSignupModal">
                            <i class="bi bi-box-arrow-left"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid header">
            <!-- Header -->
            <div class="row textBlockLeft">
                <div class="titleLeft">
                    MODERATOR DASHBOARD
                </div>
                <div class="descriptionLeft">
                    LOG AS OF <strong>MARCH 24, 2025</strong>
                </div>
            </div>

            <!-- Header Divider -->
            <div class=" decoDivideRight">
                <div class="decoBoxRight"></div>
                <div class="codeDecoRight">0905270     //</div>
                <div class="decoLineRight"></div>  
            </div>
        </div>

        <div class="container-fluid row mainBody">
            <div class="col-xl-8 col-md-12 stats">
                <!-- Dashboard -->
                <div class="row dashboard1">
                    <div class="squadStats">
                        <!-- Report Count -->
                        <div class="winRate">
                            <div class="statsContent">
                                <div class="number"><?= $reportCount ?></div>
                                <div class="statsLabel">REPORTS</div>
                            </div>
                        </div>
                        <!-- Request Count -->
                        <div class="winRate">
                            <div class="statsContent">
                                <div class="number"><?= $requestCount ?></div>
                                <div class="statsLabel">REQUESTS</div>
                            </div>
                        </div>
                        <!-- New User Count -->
                        <div class="winRate">
                            <div class="statsContent">
                                <div class="number"><?= $userCount ?></div>
                                <div class="statsLabel">NEW USERS</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Analytics -->
                <div class="row dashboard2">
                    <div class="squadStats">
                        <!-- Active Squads -->
                        <div class="winRate">
                            <div class="statsContent">
                            <div class="number"><?= $activeSquads ?></div>
                                <div class="statsLabel">ACTIVE SQUADS</div>
                            </div>
                        </div>
                        <!-- Inactive Squads -->
                        <div class="winRate">
                            <div class="statsContent">
                                <div class="number"><?= $inactiveSquads ?></div>
                                <div class="statsLabel">INACTIVE SQUADS</div>
                            </div>
                        </div>
                        <!-- Squads on Timeout -->
                        <div class="winRate">
                            <div class="statsContent">
                                <div class="number"><?= $timeoutSquads ?></div>
                                <div class="statsLabel">SQUADS ON TIMEOUT</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Admin Notes -->
            <div class="col-xl-4 col-md-12 adminNotes">
                <div class="row titleRight">ADMIN NOTES</div>
                <?php
                $sql = "SELECT tbl_admin_notes.*, tbl_useraccount.Username 
                        FROM tbl_admin_notes 
                        JOIN tbl_useraccount ON tbl_admin_notes.Admin_ID = tbl_useraccount.User_ID
                        ORDER BY Created_At DESC";
                $result = $pdo->query($sql);
                while ($note = $result->fetch()) : ?>
                    <div class="adNote">
                        <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                        <div class="adNoteText">
                            <strong><?= htmlspecialchars($note['Subject']) ?></strong><br>
                            <?= htmlspecialchars($note['Message']) ?>
                            <div class="texter text-white small mt-2">
                                Posted by <?= htmlspecialchars($note['Username']) ?> 
                                on <?= date('M j, Y g:i A', strtotime($note['Created_At'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Analytics -->
    </div>

    <!-- Javascript -->
    <script src="JS/modScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>