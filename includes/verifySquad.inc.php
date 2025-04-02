<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['user']['Squad_ID'])) {
    $_SESSION['error'] = "You must create a squad first before verifying.";
    header("Location: ../squadCreation.php");
    exit();
}


$squad_id = $_SESSION['user']['Squad_ID'];
$squad_level = $_POST['Squad_Level'];
$proof_type = $_POST['Proof_Type'];

// Handle file upload
if (isset($_FILES['Proof_File']) && $_FILES['Proof_File']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/verification/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = $_FILES['Proof_File']['name'];
    $fileTmpName = $_FILES['Proof_File']['tmp_name'];
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid('proof_', true) . '.' . $fileExt;
    $uploadPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpName, $uploadPath)) {
        $proof_file = $uploadPath;
    } else {
        $_SESSION['error'] = "Failed to upload file.";
        header("Location: ../squadCreation.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Please upload a proof file.";
    header("Location: ../squadCreation.php");
    exit();
}

// Insert into verification requests
try {
    $stmt = $pdo->prepare("INSERT INTO tbl_verificationrequests (Squad_ID, Squad_Name, Squad_Level, Proof_Type, Proof_File, Status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    $stmt->execute([$squad_id, $squad_id, $squad_level, $proof_type, $proof_file]);

    $_SESSION['success'] = "Verification request submitted successfully!";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../squadCreation.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header("Location: ../squadCreation.php");
    exit();
}