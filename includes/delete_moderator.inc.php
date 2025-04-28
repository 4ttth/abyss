<?php
// filepath: c:\xampp\htdocs\abyss\includes\delete_moderator.inc.php
session_start();
require_once 'dbh.inc.php';

// Check if the request is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mod_id'])) {
    $modId = intval($_POST['mod_id']); // Sanitize the input

    try {
        // Delete the moderator account from the database
        $query = "DELETE FROM tbl_useraccount WHERE Role = 'Moderator' AND User_ID = ?";
        // Prepare and execute the statement
        $stmt = $pdo->prepare($query);
        $stmt->execute([$modId]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Moderator account deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Moderator account not found."]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}