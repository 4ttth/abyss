<?php
include("../includes/dbh.inc.php"); // Your database connection
session_start();

if (isset($_POST['add_instruction'])) {
    $step1_title = $_POST['step1_title'];
    $step1_content = $_POST['step1_content'];
    $step2_title = $_POST['step2_title'];
    $step2_content = $_POST['step2_content'];
    $step3_title = $_POST['step3_title'];
    $step3_content = $_POST['step3_content'];
    $step4_title = $_POST['step4_title'];
    $step4_content = $_POST['step4_content'];

    $stmt = $pdo->prepare("
        INSERT INTO tbl_instructions 
        (Step1_Title, Step1_Content, Step2_Title, Step2_Content, Step3_Title, Step3_Content, Step4_Title, Step4_Content, Show_Status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Hidden')
    ");
    $stmt->execute([
        $step1_title, $step1_content,
        $step2_title, $step2_content,
        $step3_title, $step3_content,
        $step4_title, $step4_content
    ]);

    header("Location: adminInstructionsManagement.php");
    exit();
}

// Handle Show Instruction
if (isset($_POST['show_instruction'])) {
    $instruction_id = $_POST['instruction_id'];

    // Hide all first
    $pdo->query("UPDATE tbl_instructions SET Show_Status = 'Hidden'");

    // Then show only the selected
    $stmt = $pdo->prepare("UPDATE tbl_instructions SET Show_Status = 'Shown' WHERE Instruction_ID = ?");
    $stmt->execute([$instruction_id]);

    header("Location: adminInstructionsManagement.php");
    exit();
}


// Fetch Instructions
$instructions = $pdo->query("SELECT * FROM tbl_instructions ORDER BY Instruction_ID ASC")->fetchAll();
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
                        <a class="nav-link active" href="adminInstructionsManagement.php">
                            <span class="nav-text">INSTRUCTION MANAGEMENT</span>
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
        <!-- Header -->
        <div class="row textBlockLeft">
                <div class="titleLeft">
                    INSTRUCTION MANAGEMENT
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
            <!-- Add Instruction Button -->
                <button class="addContentButton" id="openModalBtn" data-bs-toggle="modal" data-bs-target="#addContentModal">
                    <i class="bi bi-node-plus-fill"></i><i class="bi bi-node-plus-fill"></i>Add Instruction
                </button>
        </div>

        <div class="container-fluid row mainBody">
            <table class="display reportsTable" id="reportsTable">
            <thead>
                    <tr>
                        <th>Instruction ID</th>
                        <th>Step 1: Title</th>
                        <th>Step 1</th>
                        <th>Step 2: Title</th>
                        <th>Step 2</th>
                        <th>Step 3: Title</th>
                        <th>Step 3</th>
                        <th>Step 4: Title</th>
                        <th>Step 4</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            <tbody>
                <?php foreach ($instructions as $instruction): ?>
                <tr>
                    <td><?php echo htmlspecialchars($instruction['Instruction_ID']); ?></td>
                    <td><?php echo htmlspecialchars($instruction['Step1_Title']); ?></td>
                    <td><?php echo htmlspecialchars($instruction['Step1_Content']); ?></td>
                    <td><?php echo htmlspecialchars($instruction['Step2_Title']); ?></td>
                    <td><?php echo htmlspecialchars($instruction['Step2_Content']); ?></td>
                    <td><?php echo htmlspecialchars($instruction['Step3_Title']); ?></td>
                    <td><?php echo htmlspecialchars($instruction['Step3_Content']); ?></td>
                    <td><?php echo htmlspecialchars($instruction['Step4_Title']); ?></td>
                    <td><?php echo htmlspecialchars($instruction['Step4_Content']); ?></td>
                    <td class="buttonColumn">
                        <form method="POST">
                            <input type="hidden" name="instruction_id" value="<?php echo $instruction['Instruction_ID']; ?>">
                            <?php if ($instruction['Show_Status'] == 'Shown'): ?>
                                <button type="button" disabled class=" buttons active-button" style="opacity: 0.5;">
                                <i class="bi bi-eye-fill"></i> Active</button>
                            <?php else: ?>
                                <button type="submit" name="show_instruction" class=" buttons show-button">Show</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>

<!-- Add Instruction Modal -->
<div class="modal fade" id="addContentModal" tabindex="-1" aria-labelledby="addContentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content customModal">
                <div class="modal-header">
                    <h5 class="modal-title" id="addContentModalLabel">ADD NEW INSTRUCTION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="mb-3">
                                <label class="form-label">STEP 1 TITLE</label>
                                <input type="text" name="step1_title" class="form-control plchldr" placeholder="Enter Step 1 Title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">STEP 1</label>
                            <textarea name="step1_content" class="form-control plchldr" rows="3" placeholder="Enter Step 1" required></textarea>
                        </div>

                        <div class="mb-3">
                                <label class="form-label">STEP 2 TITLE</label>
                                <input type="text" name="step1_title" class="form-control plchldr" placeholder="Enter Step 1 Title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">STEP 2</label>
                            <textarea name="step2_content" class="form-control plchldr" rows="3" placeholder="Enter Step 2" required></textarea>
                        </div>

                        <div class="mb-3">
                                <label class="form-label">STEP 3 TITLE</label>
                                <input type="text" name="step1_title" class="form-control plchldr" placeholder="Enter Step 1 Title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">STEP 3</label>
                            <textarea name="step3_content" class="form-control plchldr" rows="3" placeholder="Enter Step 3" required></textarea>
                        </div>

                        <div class="mb-3">
                                <label class="form-label">STEP 4 TITLE</label>
                                <input type="text" name="step1_title" class="form-control plchldr" placeholder="Enter Step 1 Title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">STEP 4</label>
                            <textarea name="step4_content" class="form-control plchldr" rows="3" placeholder="Enter Step 4" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_instruction" class="modalButtons">ADD INSTRUCTIONS</button>
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
    const modal = document.getElementById('addInstructionModal');
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
