<?php
session_start();
require_once 'dbh.inc.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $squadID = 1; // Test purposes

    // Get form data
    $content = $_POST['content'];
    $postLabel = $_POST['postLabel'] ?? null; // Optional field
    $postType = $_POST['postType'];
    // $squadID = $_SESSION['user']['Squad_ID']; // Get Squad_ID from session

    // Handle image upload
    $imageURL = null;
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '/uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['imageUpload']['name']);
        $imageURL = '/uploads/' . basename($_FILES['imageUpload']['name']); // Store web-accessible path

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploadFile)) {
            $imageURL = $uploadFile;
        } else {
            die("Failed to upload image.");
        }
    }

    // Insert post into the database
    try {
        $query = "INSERT INTO tbl_squadposts (Squad_ID, Post_Label, Content, Image_URL, Post_Type) 
                  VALUES (:squadID, :postLabel, :content, :imageURL, :postType)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':squadID', $squadID, PDO::PARAM_INT);
        $stmt->bindParam(':postLabel', $postLabel, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':imageURL', $imageURL, PDO::PARAM_STR);
        $stmt->bindParam(':postType', $postType, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect back to the homepage after posting
        header("Location: ../userHomepage.php");
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    // Redirect if the form is not submitted
    header("Location: ../userHomepage.php");
    exit();
}