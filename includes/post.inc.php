<?php
session_start();
require_once 'dbh.inc.php';

// Prevent duplicate submissions
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../userHomepage.php");
    exit();
}

// Validate session and Squad_ID
if (!isset($_SESSION['user']['Squad_ID']) || empty($_SESSION['user']['Squad_ID'])) {
    header("Location: ../userHomepage.php?error=invalid_squad");
    exit();
}

// Get validated Squad_ID
$squadID = (int)$_SESSION['user']['Squad_ID'];
error_log("Attempting post insertion for Squad_ID: $squadID"); // Debug logging

// Validate core content
if (empty(trim($_POST['content']))) {
    header("Location: ../userHomepage.php?error=empty_content");
    exit();
}

// Initialize variables
$content = trim($_POST['content']);
$postLabel = !empty(trim($_POST['postLabel'] ?? '')) ? trim($_POST['postLabel']) : null;
$postType = in_array($_POST['postType'] ?? 'public', ['public', 'private']) ? $_POST['postType'] : 'public';
$imageURL = null;

// File upload handling with validation
if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '/var/www/html/abyss/IMG/post_uploads/';
    
    // Create directory if needed
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        error_log("Failed to create upload directory");
        header("Location: ../userHomepage.php?error=upload_failed1");
        exit();
    }

    // Validate image file
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!in_array($finfo->file($_FILES['imageUpload']['tmp_name']), $allowedTypes)) {
        header("Location: ../userHomepage.php?error=invalid_image");
        exit();
    }

    // Generate unique filename
    $extension = pathinfo($_FILES['imageUpload']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_', true) . '.' . $extension;
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['imageUpload']['tmp_name'], $targetPath)) {
        $imageURL = $targetPath;
    } else {
        header("Location: ../userHomepage.php?error=upload_failed2");
        exit();
    }
}

// Database insertion with transaction
try {
    $pdo->beginTransaction();

    // Check for duplicate post within last 5 minutes
    $checkQuery = "SELECT Post_ID FROM tbl_squadposts 
                   WHERE Squad_ID = ? AND Content = ? 
                   AND TIMESTAMPDIFF(MINUTE, Timestamp, NOW()) < 5
                   LIMIT 1";
                   
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$squadID, $content]);
    
    if ($checkStmt->fetch()) {
        $pdo->rollBack();
        header("Location: ../userHomepage.php?error=duplicate_post");
        exit();
    }

    // Insert new post
    $insertQuery = "INSERT INTO tbl_squadposts 
                    (Squad_ID, Content, Image_URL, Post_Label, Post_Type) 
                    VALUES (?, ?, ?, ?, ?)";
    
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->execute([
        $squadID,
        $content,
        $imageURL,
        $postLabel,
        $postType
    ]);

    $pdo->commit();
    header("Location: ../userHomepage.php?post=success");
    exit();

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Database Error: " . $e->getMessage() . " [Squad_ID: $squadID]");
    header("Location: ../userHomepage.php?error=database_error");
    exit();
}