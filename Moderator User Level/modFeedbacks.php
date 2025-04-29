<?php
session_start();
require_once '../includes/dbh.inc.php';

if (!in_array($_SESSION['user']['Role'], ['Moderator'])) {
    header("Location: ../loginPage.php");
    exit("Access Denied!");
}

$sql = "SELECT User_ID, Feedback_Category, Feedback_Details, Date_Submitted FROM tbl_feedbacks";
$result = $pdo->query($sql);
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
    <title>ABYSS — Feedbacks</title>
    <link rel="stylesheet" type="text/css" href="CSS/modFeedbacksStyle.css">
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
            <ul class="nav flex-column">
                <li class="nav-item firstItem">
                    <a class="nav-link" href="modIndex.php">
                        HOME
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modReports.php">
                        REPORTS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="modFeedbacks.php">
                        FEEDBACKS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modRequests.php">
                        <span class="nav-text">VERIFICATION REQUESTS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modScrimsLog.php">
                        <span class="nav-text">SCRIMS LOG</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modInvitesLog.php">
                        <span class="nav-text">INVITES LOG</span>
                    </a>
                </li>
                <li class="nav-item lastItem">
                    <a class="nav-link" href="modSquadAccounts.php">
                        <span class="nav-text">SQUAD ACCOUNTS</span>
                    </a>
                </li>
            </ul>
           
            <!-- Account Logo (at bottom) -->
            <div class="nav-footer">
                <form action="../includes/logout.inc.php" method="post">
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
                    FEEDBACKS
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
            <table id="reportsTable" class="display reportsTable">
                <thead>
                    <tr>
                        <th>Squad</th>
                        <th>Category</th>
                        <th>Details</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= $row['User_ID'] ?></td>
                            <td><?= $row['Feedback_Category'] ?></td>
                            <td><?= $row['Feedback_Details'] ?></td>
                            <td><?= $row['Date_Submitted'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="JS/modFeedbacksScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>