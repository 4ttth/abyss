<?php
session_start();
require_once '../includes/dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_note'])) {

    if (!in_array($_SESSION['user']['Role'], ['Admin'])) {
        header("Location: ../loginPage.php");
        exit("Access Denied!");
    }

    $subject = trim($_POST['subject']);
    $message = trim($_POST['message_body']);
    $adminId = $_SESSION['user']['User_ID'];

    if (empty($subject) || empty($message)) {
        $_SESSION['note_error'] = "Please fill all fields.";
    } else {
        try {
            $sql = "INSERT INTO tbl_admin_notes (Admin_ID, Subject, Message) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$adminId, $subject, $message]);
            $_SESSION['note_success'] = "Note added successfully!";
        } catch (PDOException $e) {
            $_SESSION['note_error'] = "Database error: " . $e->getMessage();
        }
    }
    
    // Redirect back to clear POST data
    header("Location: adminModeratorAccounts.php");
    exit();
}

// Fetch moderator accounts
$sql = "SELECT User_ID AS Moderator_ID, Email_Address FROM tbl_useraccount WHERE Role = 'Moderator'";
$result = $pdo->query($sql);

// Display success/error messages
if (isset($_SESSION['note_success'])) {
    echo '<div class="alert alert-success" id="success-alert">' . $_SESSION['note_success'] . '</div>';
    unset($_SESSION['note_success']); // Unset the session variable
}

if (isset($_GET['error'])) {
    $error_messages = [
        'emptyfields' => 'Please fill all fields.',
        'invalidemail' => 'Invalid email format.',
        'passwordmismatch' => 'Passwords do not match.',
        'emailtaken' => 'Email already exists.',
        'usernametaken' => 'Username already taken.', // Add this line
        'sqlerror' => 'Database error. Try again.'
    ];
    echo '<div class="alert alert-danger">' . $error_messages[$_GET['error']] . '</div>';
} elseif (isset($_GET['success']) && $_GET['success'] == 'accountadded') {
        echo '<div class="alert alert-success" id="success-alert">Moderator account added successfully!</div>';
}

// $sql = "SELECT User_ID AS Moderator_ID, Email_Address FROM tbl_useraccount WHERE Role = 'Moderator'";
// // Check if the user is an admin    
// $result = $pdo->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Moderator Accounts</title>
    <link rel="stylesheet" type="text/css" href="CSS/adminModeratorManagementStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
</head>

<body>
    <!-- Loading Screen -->
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
                            <span class="nav-text">CONTENT MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../Admin User Level/adminModeratorAccounts.php">
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
                    MODERATOR ACCOUNTS
                </div>
                <div class="descriptionLeft">
                    LOG AS OF <strong><?= date('F j, Y') ?></strong>
                </div>
            </div>

            <div class="decoDivideRight">
                <div class="decoBoxRight"></div>
                <div class="codeDecoRight">0905270     //</div>
                <div class="decoLineRight"></div>  
            </div>
        </div>
        
        <div class="bodies">
            <div class="container-fluid row mainBody col-xl-9 col-md-12">
                <!-- Add Account Button -->
                <button class="addContentButton" data-bs-toggle="modal" data-bs-target="#addModeratorModal">
                    <i class="bi bi-person-plus-fill"></i> ADD ACCOUNT
                </button>
                
                <!-- Moderator Accounts Table -->
                <table id="moderatorTable" class="display">
                    <thead>
                        <tr>
                            <th>Moderator ID</th>
                            <th>Email Address</th>
                            <th>Audit Logs</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?= $row['Moderator_ID'] ?></td>
                                <td><?= $row['Email_Address'] ?></td>
                                <td>
                                    <button class="show-logs buttons" data-mod-id="<?= $row['Moderator_ID'] ?>" data-mod-email="<?= $row['Email_Address'] ?>">Show Logs</button>
                                </td>
                                <td class="buttonColumn">
                                    <button class="delete" onclick="deleteAccount(<?= $row['Moderator_ID'] ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Logs Table -->
                <div id="logsSection" style="display:none; margin-top: 30px;">
                    <div class="titleLeft">AUDIT LOGS: <span id="moderatorName"></span></div>
                    <table id="logsTable" class="display">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Will be populated by AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Part -->
            <div class="container-fluid row rightBody col-xl-3 col-md-12">
                <!-- Admin Notes Logs -->
                <div class="row adminNotes">
                    <!-- Admin Notes Form -->
                    <div class="modal-content customModal" style="margin: 20px 0; padding: 20px;">
                        <div class="modal-header">
                            <h5 class="modal-title headni2">ADMIN NOTES</h5>
                        </div>
                        
                        <?php
                        // Display messages
                        if (isset($_SESSION['note_error'])) {
                            echo '<div class="alert alert-danger">' . $_SESSION['note_error'] . '</div>';
                            unset($_SESSION['note_error']);
                        }
                        if (isset($_SESSION['note_success'])) {
                            echo '<div class="alert alert-success">' . $_SESSION['note_success'] . '</div>';
                            unset($_SESSION['note_success']);
                        }
                        ?>
                        
                        <form method="POST">
                            <!-- Subject Field -->
                            <div class="mb-3">
                                <label class="form-label">SUBJECT</label>
                                <input type="text" name="subject" class="form-control plchldr" placeholder="Enter subject" required>
                            </div>

                            <!-- Message Body -->
                            <div class="mb-3">
                                <label class="form-label">MESSAGE</label>
                                <textarea name="message_body" class="form-control plchldr" rows="5" placeholder="Write your note here..." required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="modal-footer" style="border-top: none;">
                                <button type="submit" name="submit_note" class="modalButtons">SEND NOTE</button>
                            </div>
                        </form>
                        <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            <?php
                            $error_messages = [
                                'emptyfields' => 'Please fill in all fields.',
                                'sqlerror' => 'Database error. Please try again.'
                            ];
                            echo $error_messages[$_GET['error']] ?? 'An unknown error occurred.';
                            ?>
                        </div>
                        <?php elseif (isset($_GET['success']) && $_GET['success'] === 'noteadded'): ?>
                            <div class="alert alert-success">Note added successfully!</div>
                        <?php endif; ?>
                        </div>
                </div>
            </div>
        </div>

        <!-- Add Moderator Modal -->
        <div class="modal fade" id="addModeratorModal" tabindex="-1" aria-labelledby="addModeratorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content customModal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModeratorModalLabel">ADD NEW MODERATOR</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../includes/add_moderator.inc.php" method="post">
                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">EMAIL ADDRESS</label>
                                <input type="email" name="email" class="form-control plchldr" placeholder="Enter email" required>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label class="form-label">USERNAME</label>
                                <input type="username" name="username" class="form-control plchldr" placeholder="Enter Username" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">PASSWORD</label>
                                <input type="password" name="password" class="form-control plchldr" placeholder="Enter password" required>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label">CONFIRM PASSWORD</label>
                                <input type="password" name="confirm_password" class="form-control plchldr" placeholder="Confirm password" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="modal-footer">
                                <button type="submit" name="submit" class="modalButtons">ADD MODERATOR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="JS/adminModeratorManagementScript.js"></script>
</body>
</html>