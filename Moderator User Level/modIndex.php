<?php
session_start();
require_once 'includes/dbh.inc.php';

if (!in_array($_SESSION['user_role'], ['Moderator'])) {
    exit("Access Denied!");
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
            <ul class="nav flex-column">
                <li class="nav-item firstItem">
                    <a class="nav-link active" href="modIndex.html">
                        HOME
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modReports.php">
                        REPORTS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modFeedbacks.php">
                        FEEDBACKS
                    </a>
                </li>
                <li class="nav-item lastItem">
                    <a class="nav-link" href="modRequests.php">
                        <span class="nav-text">VERIFICATION REQUESTS</span>
                    </a>
                </li>
            </ul>
            
            <!-- Account Logo (at bottom) -->
            <div class="nav-footer">
                <button class="accountLogo" data-bs-toggle="modal" data-bs-target="#loginSignupModal">
                    <i class="bi bi-box-arrow-left"></i>
                </button>
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
                                <div class="number">4</div>
                            <div class="statsLabel">REPORTS</div>
                            </div>
                        </div>
                        <!-- Request Count -->
                        <div class="winRate">
                            <div class="statsContent">
                                <div class="number">2</div>
                            <div class="statsLabel">REQUESTS</div>
                            </div>
                        </div>
                        <!-- New User Count -->
                        <div class="winRate">
                            <div class="statsContent">
                                <div class="number">13</div>
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
                                <div class="number">304</div>
                            <div class="statsLabel">ACTIVE SQUADS</div>
                            </div>
                        </div>
                        <!-- Inactive Squads -->
                        <div class="winRate">
                            <div class="statsContent">
                                <div class="number">4</div>
                            <div class="statsLabel">INACTIVE SQUADS</div>
                            </div>
                        </div>
                        <!-- Squads on Timeout -->
                        <div class="winRate">
                            <div class="statsContent">
                                <div class="number">5</div>
                            <div class="statsLabel">SQUADS ON TIMEOUT</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Admin Notes -->
            <div class="col-xl-4 col-md-12 adminNotes">
                <!-- Header -->
                <div class=" row titleRight">
                    ADMIN NOTES
                </div>
                <!-- Admin Note Post -->
                <div class=" adNote">
                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                    <div class="adNoteText">
                        <strong>Squad Verification:</strong> Check pending squad requests regularly. Approve or reject based on provided details.
                    </div>
                </div>
                <!-- Sample 2 -->
                <div class=" adNote">
                    <img src="IMG/essentials/whiteVer.PNG" alt="Fox Icon" class="foxIcon">
                    <div class="adNoteText">
                        <strong>Reports Handling:</strong> Review player reports fairly. Mark them as Pending, Reviewed, or Action Taken accordingly.
                    </div>
                </div>

            </div>

        </div>

        <!-- Analytics -->
    </div>

    <!-- Javascript -->
    <script src="JS/modScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>