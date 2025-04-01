<?php
// Database connection
$host = 'localhost';
$dbname = 'mlofficial_database';
$dbusername = 'root';
$dbpassword = '';

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Extract data from the request
$squadId = $data['squadId'];
$date = $data['date'];
$time = $data['time'];
$notes = $data['notes'];

// Insert the scrim schedule into the database
$query = "INSERT INTO tbl_scrimschedules (Squad_ID, Scrim_Date, Scrim_Time, Scrim_Notes) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isss", $squadId, $date, $time, $notes);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to schedule scrim."]);
}

$stmt->close();
$conn->close();
?>