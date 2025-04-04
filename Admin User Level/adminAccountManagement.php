<?php
session_start();
require_once '../includes/dbh.inc.php';

if (!in_array($_SESSION['user_role'], ['Admin'])) {
    exit("Access Denied!");
}

if (!isset($pdo)) {
    die("Database connection failed!");
}

$sql = "SELECT Request_ID, Squad_ID, Squad_Name, Squad_Level, Proof_Type, Proof_File, Date_Submitted, Status, Date_Reviewed 
        FROM tbl_verificationrequests";
$result = $pdo->query($sql);

if (!$result) {
    die("Query failed: " . $pdo->error);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Account Management</title>
    <link rel="stylesheet" type="text/css" href="CSS/adminAccountManagementStyle.css">
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
                    <a class="nav-link" href="adminIndex.php">
                        HOME
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminContentManagement.php">
                        <span class="nav-text">CONTENT MANAGEMENT</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminModeratorManagement.php">
                        <span class="nav-text">MODERATOR MANAGEMENT</span>
                    </a>
                </li>
                <li class="nav-item lastItem">
                    <a class="nav-link active" href="adminAccountManagement.php">
                        <span class="nav-text">ACCOUNT MANAGEMENT</span>
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

        <!-- Squad Account -->
        <div class="container-fluid header">
            <!-- Header -->
            <div class="row textBlockLeft">
                <div class="titleLeft">
                    SQUAD ACCOUNTS MANAGEMENT
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
                    <th>User ID</th>
                    <th>Squad Name</th>
                    <th>Squad Level</th>
                    <th>Proof Type</th>
                    <th>Proof File</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                    <th>Action Timestamp</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                        <td><?= $row['Squad_ID'] ?></td>
                        <td><?= $row['Squad_Name'] ?></td>
                        <td><?= $row['Squad_Level'] ?></td>
                        <td><?= $row['Proof_Type'] ?></td>
                        <td class="buttonColumn">
                            <?php if (!empty($row['Proof_File'])): ?>
                                <button class="buttons view" onclick="window.open('<?= htmlspecialchars($row['Proof_File']) ?>', '_blank')">View File</button>
                            <?php else: ?>
                                <span>No File</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $row['Date_Submitted'] ?></td>
                        <td><?= $row['Status'] ?></td>
                        <td><?= $row['Date_Reviewed'] ? $row['Date_Reviewed'] : 'Pending' ?></td>
                        <td class="buttonColumn">
                            <button class="approve" onclick="approveRequest(<?= $row['Request_ID'] ?>)">Approve</button>
                            <button class="reject" onclick="rejectRequest(<?= $row['Request_ID'] ?>)">Reject</button>
                        </td>                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
                <!-- Squad Account -->
                <div class="container-fluid header">
            <!-- Header -->
            <div class="row textBlockLeft">
                <div class="titleLeft">
                    SQUAD ACCOUNTS MANAGEMENT
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
                    <th>User ID</th>
                    <th>Squad Name</th>
                    <th>Squad Level</th>
                    <th>Proof Type</th>
                    <th>Proof File</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                    <th>Action Timestamp</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                        <td><?= $row['Squad_ID'] ?></td>
                        <td><?= $row['Squad_Name'] ?></td>
                        <td><?= $row['Squad_Level'] ?></td>
                        <td><?= $row['Proof_Type'] ?></td>
                        <td class="buttonColumn">
                            <?php if (!empty($row['Proof_File'])): ?>
                                <button class="buttons view" onclick="window.open('<?= htmlspecialchars($row['Proof_File']) ?>', '_blank')">View File</button>
                            <?php else: ?>
                                <span>No File</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $row['Date_Submitted'] ?></td>
                        <td><?= $row['Status'] ?></td>
                        <td><?= $row['Date_Reviewed'] ? $row['Date_Reviewed'] : 'Pending' ?></td>
                        <td class="buttonColumn">
                            <button class="approve" onclick="approveRequest(<?= $row['Request_ID'] ?>)">Approve</button>
                            <button class="reject" onclick="rejectRequest(<?= $row['Request_ID'] ?>)">Reject</button>
                        </td>                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="JS/adminScript.js"></script>
    <script src="JS/adminAccountManagementSript.js"></script>
    
</body>
</html>