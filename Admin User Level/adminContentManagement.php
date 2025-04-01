<?php
session_start();
require_once '../includes/dbh.inc.php';

if (!in_array($_SESSION['user_role'], ['Admin'])) {
    exit("Access Denied!");
}

if (!isset($pdo)) {
    die("Database connection failed!");
}

$sql = "SELECT Content_ID, Event_Name, Event_Duration, Event_Details, Promotional_Content, Youtube_Link, Youtube_Banner, Advertisement_Link, Advertisement_Banner, Is_Displayed FROM tbl_contentmanagement";
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
    <title>ABYSS — Content Management</title>
    <link rel="stylesheet" type="text/css" href="CSS/adminContentManagementStyle.css">
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
                    <a class="nav-link" href="adminIndex.html">
                        HOME
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="adminContentManagement.php">
                        <span class="nav-text">CONTENT MANAGEMENT</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminModeratorManagement.php">
                        <span class="nav-text">MODERATOR MANAGEMENT</span>
                    </a>
                </li>
                <li class="nav-item lastItem">
                    <a class="nav-link" href="adminAccountManagement.php">
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

        <!-- Main Content -->
        <div class="container-fluid header">
            <!-- Header -->
            <div class="row textBlockLeft">
                <div class="titleLeft">
                    CONTENT MANAGEMENT
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
            <!-- Add Content Button -->
            <button class="addContentButton" data-bs-toggle="modal" data-bs-target="#addContentModal">
                <i class="bi bi-node-plus-fill"></i> ADD CONTENT
            </button>
            
            <table id="reportsTable" class="display reportsTable">
                <thead>
                    <tr>
                        <th>Content ID</th>
                        <th>Event Name</th>
                        <th>Event Duration</th>
                        <th>Event Details</th>
                        <th>Promotional Content</th>
                        <th>YouTube Link</th>
                        <th>YouTube Banner</th>
                        <th>Advertisement Link</th>
                        <th>Advertisement Banner</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['Content_ID'] ?></td>
                            <td><?= $row['Event_Name'] ?></td>
                            <td><?= $row['Event_Duration'] ?></td>
                            <td><?= $row['Event_Details'] ?></td>
                            <<td class="buttonColumn">
                                <?php if (!empty($row['Promotional_Content'])): ?>
                                    <img src="<?= htmlspecialchars($row['Promotional_Content']) ?>" alt="Promotional Content" width="100">
                                <?php else: ?>
                                    <span>No Content</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($row['Youtube_Link'])): ?>
                                    <button class="buttons" onclick="window.open('<?= htmlspecialchars($row['Youtube_Link']) ?>', '_blank')">View Link</button>
                                <?php else: ?>
                                    <span>No Link</span>
                                <?php endif; ?>
                            </td>
                            <td class="buttonColumn">
                                <?php if (!empty($row['Youtube_Banner'])): ?>
                                    <img src="<?= htmlspecialchars($row['Youtube_Banner']) ?>" alt="YouTube Banner" width="100">
                                <?php else: ?>
                                    <span>No Banner</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($row['Advertisement_Link'])): ?>
                                    <button class="buttons" onclick="window.open('<?= htmlspecialchars($row['Advertisement_Link']) ?>', '_blank')">View Link</button>
                                <?php else: ?>
                                    <span>No Link</span>
                                <?php endif; ?>
                            </td>
                            <td class="buttonColumn">
                                <?php if (!empty($row['Advertisement_Banner'])): ?>
                                    <img src="<?= htmlspecialchars($row['Advertisement_Banner']) ?>" alt="Advertisement Banner" width="100">
                                <?php else: ?>
                                    <span>No Banner</span>
                                <?php endif; ?>
                            </td>
                            <td class="buttonColumn">
                                <?php if ($row['Is_Displayed'] == 1): ?>
                                    <button class="buttons" style="opacity: 0.5; pointer-events: none;" disabled>
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                <?php else: ?>
                                    <button class="buttons" onclick="toggleDisplay(<?= $row['Content_ID'] ?>, <?= $row['Is_Displayed'] ?>)">Show</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Content Modal -->
    <div class="modal fade" id="addContentModal" tabindex="-1" aria-labelledby="addContentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content customModal">
                <div class="modal-header">
                    <h5 class="modal-title" id="addContentModalLabel">ADD NEW CONTENT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="includes/add_content.inc.php" method="post" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label">EVENT NAME</label>
                            <input type="text" name="event_name" class="form-control plchldr" placeholder="Enter event name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">EVENT DURATION</label>
                            <input type="text" name="event_duration" class="form-control plchldr" placeholder="Enter event duration" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">EVENT DETAILS</label>
                            <textarea name="event_details" class="form-control plchldr" rows="3" placeholder="Enter event details" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">PROMOTIONAL CONTENT</label>
                            <input type="file" name="promotional_content" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">YOUTUBE LINK</label>
                            <input type="url" name="youtube_link" class="form-control plchldr" placeholder="Enter YouTube link">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">YOUTUBE BANNER</label>
                            <input type="file" name="youtube_banner" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ADVERTISEMENT LINK</label>
                            <input type="url" name="advertisement_link" class="form-control plchldr" placeholder="Enter advertisement link">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ADVERTISEMENT BANNER</label>
                            <input type="file" name="advertisement_banner" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="modalButtons">ADD CONTENT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="JS/adminContentManagementScript.js"></script>
    <script src="JS/adminScript.js"></script>
    
</body>
</html>