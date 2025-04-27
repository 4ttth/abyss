<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit_feedback'])) {
    header("Location: /feedbacksPage.php");
    exit();
}

// Validate inputs
$userID = $_SESSION['user']['User_ID'] ?? null;
$receiverID = filter_input(INPUT_POST, 'receiver_id', FILTER_VALIDATE_INT);
$category = filter_input(INPUT_POST, 'feedback_category', FILTER_SANITIZE_STRING);
$details = filter_input(INPUT_POST, 'feedback_details', FILTER_SANITIZE_STRING);

// Check required fields
if (!$userID || !$receiverID || !$category || !$details) {
    header("Location: /feedbacksPage.php?error=missing_fields");
    exit();
}

try {
    // Verify receiver squad exists
    $stmt = $pdo->prepare("SELECT 1 FROM tbl_squadprofile WHERE Squad_ID = ? LIMIT 1");
    $stmt->execute([$receiverID]);
    if (!$stmt->fetch()) {
        header("Location: /feedbacksPage.php?error=invalid_squad");
        exit();
    }

    // Insert feedback
    $stmt = $pdo->prepare("
        INSERT INTO tbl_feedbacks (
            User_ID,
            Receiver_ID,
            Feedback_Category,
            Feedback_Details
        ) VALUES (?, ?, ?, ?)
    ");
    
    $stmt->execute([$userID, $receiverID, $category, $details]);
    
    header("Location: /feedbackSuccess.php");
    exit();

} catch (PDOException $e) {
    error_log("Feedback Error: " . $e->getMessage());
    header("Location: /feedbacksPage.php?error=database_error");
    exit();
}