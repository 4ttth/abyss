<?php
include("../includes/dbh.inc.php"); // Your database connection
session_start();

if (isset($_POST['add_video'])) {
    // Define the upload directory
    $uploadDir = '../uploads/videoads/';

    // Ensure the directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Allowed file types
    $allowedTypes = ['video/mp4', 'video/webm', 'video/ogg'];

    // Handle the video file upload
    $videoAd = $_FILES['videoAd']['name'] ? $uploadDir . basename($_FILES['videoAd']['name']) : null;

    // Validate and move uploaded file
    if ($videoAd && !in_array($_FILES['videoAd']['type'], $allowedTypes)) {
        die('Invalid file type for Video Advertisement');
    }
    if ($videoAd && !move_uploaded_file($_FILES['videoAd']['tmp_name'], $videoAd)) {
        die('Error uploading Video Advertisement');
    }

    // Insert file path into the database
    $stmt = $pdo->prepare("
        INSERT INTO tbl_videoads 
        (VideoAd_Path, Show_Status) 
        VALUES (?, 'Hidden')
    ");
    $stmt->execute([
        $videoAd
    ]);

    // Redirect back to the page
    header("Location: adminVideoAdManagement.php");
    exit();
}

// Handle Show Video
if (isset($_POST['show_video'])) {
    $videoad_id = $_POST['videoad_id'];

    // Hide all first
    $pdo->query("UPDATE tbl_videoads SET Show_Status = 'Hidden'");

    // Then show only the selected
    $stmt = $pdo->prepare("UPDATE tbl_videoads SET Show_Status = 'Shown' WHERE VideoAd_ID = ?");
    $stmt->execute([$videoad_id]);

    header("Location: adminVideoAdManagement.php");
    exit();
}

// Fetch Video Ads
$videoads = $pdo->query("SELECT * FROM tbl_videoads ORDER BY VideoAd_ID ASC")->fetchAll();
?>

<!DOCTYPE html>
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
            <div class="navBarOverflow">
                <ul class="nav flex-column">
                    <li class="nav-item firstItem">
                        <a class="nav-link" href="adminIndex.php">
                            HOME
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminContentManagement.php">
                            <span class="nav-text">EVENT MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminInstructionsManagement.php">
                            <span class="nav-text">INSTRUCTION MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminCarouselManagement.php">
                            <span class="nav-text">CAROUSEL MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="adminVideoAdManagement.php">
                            <span class="nav-text">VIDEO AD MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminModeratorAccounts.php">
                            <span class="nav-text">MODERATOR ACCOUNTS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modSquadAccounts.php">
                            <span class="nav-text">SQUAD ACCOUNTS</span>
                        </a>
                    </li>
                    <!-- Moderator Priivileges -->
                    <li class="nav-item">
                    <a class="nav-link" href="../Admin User Level/Moderator Functions/modIndex.php">
                            <span class="nav-text">MODERATOR INDEX</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modReports.php">
                            REPORTS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modFeedbacks.php">
                            FEEDBACKS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modRequests.php">
                            <span class="nav-text">VERIFICATION REQUESTS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modScrimsLog.php">
                            <span class="nav-text">SCRIMS LOG</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin User Level/Moderator Functions/modInvitesLog.php">
                            <span class="nav-text">INVITES LOG</span>
                        </a>
                    </li>
                </ul>
            </div>
            
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
            <div class="row textBlockLeft">
                <div class="titleLeft">
                    VIDEO ADVERTISEMENT MANAGEMENT
                </div>
                <div class="descriptionLeft">
                    LOG AS OF <strong>MARCH 24, 2025</strong>
                </div>
            </div>

            <div class="container-fluid row mainBody">
                <!-- Add Video Ad Button -->
                <button class="addContentButton" id="openModalBtn" data-bs-toggle="modal" data-bs-target="#addContentModal">
                    <i class="bi bi-node-plus-fill"></i><i class="bi bi-node-plus-fill"></i>Add Video Ad
                </button>
            </div>

            <div class="container-fluid row mainBody">
                <table class="display reportsTable" id="reportsTable">
                    <thead>
                        <tr>
                            <th>Advertisement_ID</th>
                            <th>Video Advertisement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($videoads as $videoad): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($videoad['VideoAd_ID']); ?></td>
                            <td>
                                <?php if (!empty($videoad['VideoAd_Path'])): ?>
                                    <video width="200" controls>
                                        <source src="<?php echo htmlspecialchars($videoad['VideoAd_Path']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php else: ?>
                                    No Video
                                <?php endif; ?>
                            </td>
                            <td class="buttonColumn">
                                <form method="POST">
                                    <input type="hidden" name="videoad_id" value="<?php echo $videoad['VideoAd_ID']; ?>">
                                    <?php if ($videoad['Show_Status'] == 'Shown'): ?>
                                        <button type="button" disabled class="buttons active-button" style="opacity: 0.5;">
                                            <i class="bi bi-eye-fill"></i> Active
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" name="show_video" class="buttons show-button">Show</button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

<!-- Add Video Ad Modal -->
<div class="modal fade" id="addContentModal" tabindex="-1" aria-labelledby="addContentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content customModal">
                <div class="modal-header">
                    <h5 class="modal-title" id="addContentModalLabel">ADD NEW VIDEO ADVERTISEMENT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">VIDEO ADVERTISEMENT</label>
                            <input type="file" name="videoAd" class="form-control" accept="video/*">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_video" class="modalButtons">ADD VIDEO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

<!-- Javascript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const openModalBtn = document.getElementById('openModalBtn');
    const modal = document.getElementById('addVideoAdModal');
    const closeModalBtn = document.getElementById('closeModalBtn');

    // Open Modal
    openModalBtn.addEventListener('click', function() {
        modal.style.display = 'block';
    });

    // Close Modal
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close if clicking outside modal content
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="JS/adminContentManagementScript.js"></script>
<script src="JS/adminScript.js"></script>
</html>
