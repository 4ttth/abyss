<?php
session_start();
require_once '/includes/dbh.inc.php'; 

// Ensure the user is logged in
if (!isset($_SESSION['user']['Squad_ID'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit;
}

$squadID = $_SESSION['user']['Squad_ID'];
$content = $_POST['content'] ?? '';
$postLabel = $_POST['post_label'] ?? '';
$postType = $_POST['post_type'] ?? 'public'; 
$imageURL = '';

// Handle image upload
if (!empty($_FILES['image']['name'])) {
    $uploadDir = "uploads/"; 
    $imageName = basename($_FILES['image']['name']);
    $imagePath = $uploadDir . time() . "_" . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], "/" . $imagePath)) {
        $imageURL = $imagePath;
    } else {
        echo json_encode(["status" => "error", "message" => "Image upload failed"]);
        exit;
    }
}

// Insert post into database
try {
    $stmt = $pdo->prepare("INSERT INTO tbl_squadposts (Squad_ID, Post_Label, Content, Image_URL, Post_Type, Timestamp) 
                           VALUES (:squadID, :postLabel, :content, :imageURL, :postType, NOW())");
    $stmt->execute([
        ':squadID' => $squadID,
        ':postLabel' => $postLabel,
        ':content' => $content,
        ':imageURL' => $imageURL,
        ':postType' => $postType
    ]);

    echo json_encode(["status" => "success", "message" => "Post created!"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>
