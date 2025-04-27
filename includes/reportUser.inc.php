<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit_report'])) {
    header("Location: ../reportsPage.php");
    exit();
}

// 1. Validate all inputs
$reporterID = $_SESSION['user']['User_ID'] ?? null;
$reportedSquadID = filter_input(INPUT_POST, 'reported_squad_id', FILTER_VALIDATE_INT);
$category = filter_input(INPUT_POST, 'report_category', FILTER_SANITIZE_STRING);
$details = filter_input(INPUT_POST, 'report_details', FILTER_SANITIZE_STRING);

// 2. Basic validation
if (!$reporterID || !$reportedSquadID || !$category || !$details) {
    header("Location: ../reportsPage.php?error=invalid_input");
    exit();
}

// 3. File upload handling
$proofPath = null;
if (isset($_FILES['proof_file']) && $_FILES['proof_file']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    $fileType = $_FILES['proof_file']['type'];
    $fileSize = $_FILES['proof_file']['size'];
    
    if (!in_array($fileType, $allowedTypes)) {  // Fixed this line - added missing parenthesis
        header("Location: ../reportsPage.php?error=invalid_file_type");
        exit();
    }
    
    if ($fileSize > $maxSize) {
        header("Location: ../reportsPage.php?error=file_too_large");
        exit();
    }
    
    $uploadDir = '../uploads/reports/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $fileExt = pathinfo($_FILES['proof_file']['name'], PATHINFO_EXTENSION);
    $proofPath = $uploadDir . uniqid('report_', true) . '.' . $fileExt;
    
    if (!move_uploaded_file($_FILES['proof_file']['tmp_name'], $proofPath)) {
        header("Location: ../reportsPage.php?error=file_upload");
        exit();
    }
}

// 4. Database insertion
try {
    $stmt = $pdo->prepare("
        INSERT INTO tbl_reports (
            Reporter_ID,
            Reported_User_ID,
            Report_Category,
            Report_Details,
            Proof_File,
            Report_Status,
            Date_Reported
        ) VALUES (?, ?, ?, ?, ?, 'Pending', NOW())
    ");
    
    $stmt->execute([
        $reporterID,
        $reportedSquadID,
        $category,
        $details,
        $proofPath
    ]);
    
    // After successfully inserting the report into the database
    // but BEFORE the redirect, add:
    $_SESSION['report_submitted'] = true;

    // Then redirect
    header("Location: ../reportSuccess.php");
    exit();
    
} catch (PDOException $e) {
    // Delete uploaded file if database insert fails
    if ($proofPath && file_exists($proofPath)) {
        unlink($proofPath);
    }
    header("Location: ../reportsPage.php?error=db_error");
    exit();
}