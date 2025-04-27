<?php
session_start();
require_once 'includes/dbh.inc.php';


if (!in_array($_SESSION['user']['Role'], ['Admin'])) {
    header("Location: /loginPage.php");
    exit("Access Denied!");
}


$sql = "SELECT Report_ID, Reporter_ID, Reported_User_ID, Report_Category, Proof_File, Report_Status, Date_Reported FROM tbl_reports";
$result = $pdo->query($sql);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Reports</title>
    <link rel="stylesheet" type="text/css" href="CSS/modReportsStyle.css">
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
                        <a class="nav-link active" href="/Moderator Functions/modReports.php">
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
                    REPORTS
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
                        <th>Report ID</th>
                        <th>Reporter</th>
                        <th>Reported User</th>
                        <th>Category</th>
                        <th>Proof File</th>
                        <th>Status</th>
                        <th>Date Reported</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= $row['Report_ID'] ?></td>
                            <td><?= $row['Reporter_ID'] ?></td>
                            <td><?= $row['Reported_User_ID'] ?></td>
                            <td><?= $row['Report_Category'] ?></td>
                            <td class="buttonColumn">
                                <?php if (!empty($row['Proof_File'])): ?>
                                    <button class="buttons view" onclick="window.open('<?= htmlspecialchars($row['Proof_File']) ?>', '_blank')">View File</button>
                                <?php else: ?>
                                    <span>No File</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $row['Report_Status'] ?></td>
                            <td><?= $row['Date_Reported'] ?></td>
                            <td class="buttonColumn">
                                <button class="penalize" onclick="penalize(<?= $row['Report_ID'] ?>)">Penalize</button>
                                <button class="buttons" onclick="deleteReport(<?= $row['Report_ID'] ?>)">Delete</button>
                            </td>  
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>


        <!-- Penalty Modal -->
        <div class="modal fade" id="penaltyModal" tabindex="-1" aria-labelledby="penaltyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content customModal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="penaltyModalLabel">APPLY PENALTY</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="includes/applyPenalty.php" method="post" id="penaltyForm">
                            <input type="hidden" id="penaltyReportId" name="report_id">
                           
                            <!-- Penalty Type Selection -->
                            <div class="mb-3">
                                <label class="form-label">PENALTY TYPE</label>
                                <div class="dropdown-wrapper">
                                    <select name="penalty_type" class="squadLevelDropdown" id="penaltyType" onchange="toggleDurationField()">
                                        <option selected disabled>Select Penalty</option>
                                        <option value="timeout">Timeout</option>
                                        <option value="ban">Permanent Ban</option>
                                        <option value="warning">Warning</option>
                                    </select>
                                    <span class="dropdown-icon-penalty">▼</span>
                                </div>
                            </div>
                           
                            <!-- Duration Field (shown only for timeout) -->
                            <div class="mb-3" id="durationField" style="display: none;">
                                <label class="form-label">DURATION</label>
                                <div class="dropdown-wrapper">
                                    <select name="duration" class="squadLevelDropdown">
                                        <option value="1">1 Day</option>
                                        <option value="3">3 Days</option>
                                        <option value="7">1 Week</option>
                                        <option value="30">1 Month</option>
                                        <option value="90">3 Months</option>
                                        <option value="180">6 Months</option>
                                    </select>
                                    <span class="dropdown-icon-timeout ">▼</span>
                                </div>
                            </div>
                           
                            <!-- Reason Field -->
                            <div class="mb-3">
                                <label class="form-label">REASON</label>
                                <textarea name="reason" class="form-control plchldr" rows="3" placeholder="Enter penalty reason" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="modalButtons">APPLY PENALTY</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- Penalty Modal -->
    <div class="modal fade" id="penaltyModal" tabindex="-1" aria-labelledby="penaltyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content customModal">
                <div class="modal-header">
                    <h5 class="modal-title" id="penaltyModalLabel">Apply Penalty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="includes/applyPenalty.php" method="post" id="penaltyForm">
                        <!-- Hidden Field for Report ID -->
                        <input type="hidden" id="penaltyReportId" name="report_id">

                        <!-- Penalty Type Selection -->
                        <div class="mb-3">
                            <label class="form-label">Penalty Type</label>
                            <div class="dropdown-wrapper">
                                <select name="penalty_type" class="squadLevelDropdown" id="penaltyType" onchange="toggleDurationField()" required>
                                    <option selected disabled>Select Penalty</option>
                                    <option value="timeout">Timeout</option>
                                    <option value="ban">Permanent Ban</option>
                                    <option value="warning">Warning</option>
                                </select>
                                <span class="dropdown-icon-penalty">▼</span>
                            </div>
                        </div>

                        <!-- Duration Field (shown only for timeout) -->
                        <div class="mb-3" id="durationField" style="display: none;">
                            <label class="form-label">Duration</label>
                            <div class="dropdown-wrapper">
                                <select name="duration" class="squadLevelDropdown">
                                    <option value="1">1 Day</option>
                                    <option value="3">3 Days</option>
                                    <option value="7">1 Week</option>
                                    <option value="30">1 Month</option>
                                    <option value="90">3 Months</option>
                                    <option value="180">6 Months</option>
                                </select>
                                <span class="dropdown-icon-timeout">▼</span>
                            </div>
                        </div>

                        <!-- Reason Field -->
                        <div class="mb-3">
                            <label class="form-label">Reason</label>
                            <textarea name="reason" class="form-control plchldr" rows="3" placeholder="Enter penalty reason" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="penaltyForm" class="modalButtons">Apply Penalty</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="JS/modReportsScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>