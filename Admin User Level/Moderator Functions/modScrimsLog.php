<?php
session_start();
require_once '/includes/dbh.inc.php';


if (!in_array($_SESSION['user']['Role'], ['Admin'])) {
    header("Location: /loginPage.php");
    exit("Access Denied!");
}

$sql = "SELECT Match_ID, Squad1_ID, Squad2_ID, Scheduled_Time, Status, Winner_Squad_ID, Winner_Score, Loser_Score, Screenshot_Proof, OCR_Validated FROM tbl_scrimslog";
$result = $pdo->query($sql);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Scrims Log</title>
    <link rel="stylesheet" type="text/css" href="CSS/modScrimsLogStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
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
                    <a class="nav-link" href="/Moderator Functions/modIndex.php">
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
                        <a class="nav-link active" href="/Moderator Functions/modScrimsLog.php">
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
                <form action="/includes/logout.inc.php" method="post">
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
                    SCRIMS LOG
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
            <table id="scrimsTable" class="display scrimsTable">
                <thead>
                    <tr>
                        <th>Match ID</th>
                        <th>Squad 1</th>
                        <th>Squad 2</th>
                        <th>Scheduled Time</th>
                        <th>Status</th>
                        <th>Winner</th>
                        <th>Score</th>
                        <th>Proof</th>
                        <th>OCR Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= $row['Match_ID'] ?></td>
                            <td><?= $row['Squad1_ID'] ?></td>
                            <td><?= $row['Squad2_ID'] ?></td>
                            <td><?= $row['Scheduled_Time'] ?></td>
                            <td><?= $row['Status'] ?></td>
                            <td><?= $row['Winner_Squad_ID'] ?: 'Draw' ?></td>
                            <td><?= $row['Winner_Score'] ?>-<?= $row['Loser_Score'] ?></td>
                            <td>
                                <?php if ($row['Screenshot_Proof']): ?>
                                    <a href="<?= $row['Screenshot_Proof'] ?>" target="_blank">View</a>
                                <?php else: ?>
                                    None
                                <?php endif; ?>
                            </td>
                            <td><?= $row['OCR_Validated'] ? 'Valid' : 'Pending' ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="JS/modScrimsLogScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>