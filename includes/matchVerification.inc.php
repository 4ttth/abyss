<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_submit'])) {
    $scrimID = $_POST['scrim_id'] ?? null;
    $yourScore = $_POST['your_score'] ?? null;
    $opponentScore = $_POST['opponent_score'] ?? null;
    $squadID = $_SESSION['user']['Squad_ID'] ?? null;

    // Validate inputs
    if (!$scrimID || !$yourScore || !$opponentScore || !$squadID) {
        header("Location: matchVerificationPage.php?scrim_id=$scrimID&error=missing_fields");
        exit();
    }

    // File upload handling
    $file = $_FILES['Proof_File'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    
    if ($fileError !== UPLOAD_ERR_OK) {
        header("Location: matchVerificationPage.php?scrim_id=$scrimID&error=file_upload");
        exit();
    }

    // Generate unique filename
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid('proof_', true) . '.' . $fileExt;
    $uploadPath = 'uploads/match_proofs/' . $newFileName;

    // if (!move_uploaded_file($fileTmpName, $uploadPath)) {
    //     header("Location: matchVerificationPage.php?scrim_id=$scrimID&error=file_move");
    //     exit();
    // }

    // Insert verification into database
    try {
        $stmt = $pdo->prepare("INSERT INTO tbl_matchverifications 
                              (Match_ID, Squad_ID, Your_Score, Opponent_Score, Proof_File) 
                              VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$scrimID, $squadID, $yourScore, $opponentScore, $uploadPath]);

        // Update scrim log to mark as verification submitted
        $stmt = $pdo->prepare("UPDATE tbl_scrimslog 
                              SET Verification_Submitted = 1 
                              WHERE Match_ID = ?");
        $stmt->execute([$scrimID]);

        $_SESSION['verification_submitted'] = true;
        header("Location: ../verificationSuccess.php");
        exit();
    } catch (PDOException $e) {
        // Handle database error
        header("Location: matchVerificationPage.php?scrim_id=$scrimID&error=database");
        exit();
    }
} else {
    header("Location: invitesPage.php");
    exit();
}