<?php
session_start();
require_once 'dbh.inc.php'; // Ensure this path is correct

// Debugging headers
header('Content-Type: application/json');

// Validate session and role
if (!isset($_SESSION['user']['Role'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

if ($_SESSION['user']['Role'] !== 'Admin') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Validate input
$contentId = filter_input(INPUT_POST, 'content_id', FILTER_VALIDATE_INT);
$isDisplayed = filter_input(INPUT_POST, 'is_displayed', FILTER_VALIDATE_INT);

if (!$contentId || !in_array($isDisplayed, [0, 1])) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Deactivate all if activating a new content
    if ($isDisplayed == 1) {
        $stmt = $pdo->prepare("UPDATE tbl_contentmanagement SET Is_Displayed = 0");
        $stmt->execute();
    }

    // Update the selected content
    $stmt = $pdo->prepare("UPDATE tbl_contentmanagement SET Is_Displayed = ? WHERE Content_ID = ?");
    $stmt->execute([$isDisplayed, $contentId]);

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}