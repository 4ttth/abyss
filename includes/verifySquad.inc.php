<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Get form data
        $squadLevel = trim($_POST['Squad_Level']);
        $proofType = trim($_POST['Proof_Type'] ?? 'N/A');
        $squadID = $_SESSION['user']['Squad_ID'];
        $proofFile = 'N/A';

        // Validate Squad Level
        $allowedLevels = ['Amateur', 'Collegiate', 'Professional'];
        if (!in_array($squadLevel, $allowedLevels)) {
            throw new Exception("Invalid squad level selection.");
        }

        // Handle file upload for non-Amateur levels
        if ($squadLevel !== 'Amateur') {
            // Validate required fields for non-Amateur
            if (empty($proofType)) {
                throw new Exception("Proof Type is required.");
            }

            // File upload handling
            if (!isset($_FILES['Proof_File']) || $_FILES['Proof_File']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Proof file is required.");
            }

            $uploadDir = '/uploads/verification/';
            $fileName = uniqid('proof_') . '_' . basename($_FILES['Proof_File']['name']);
            $targetPath = $uploadDir . $fileName;

            // Validate file type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
            $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("Only JPG, PNG, and PDF files are allowed.");
            }

            // Move uploaded file
            if (!move_uploaded_file($_FILES['Proof_File']['tmp_name'], $targetPath)) {
                throw new Exception("Error uploading file.");
            }

            $proofFile = $targetPath;
        }

        // Insert verification request
        $sql = "INSERT INTO tbl_verificationrequests 
                (Squad_ID, Squad_Level, Proof_Type, Proof_File, Status, Date_Submitted)
                VALUES (?, ?, ?, ?, 'Pending', NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$squadID, $squadLevel, $proofType, $proofFile]);

        $_SESSION['success'] = "Verification request submitted successfully!";
        header("Location: /squadCreation.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: /squadCreation.php");
        exit();
    }
} else {
    header("Location: /squadCreation.php");
    exit();
}