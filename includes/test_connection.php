<?php
$host = 'localhost';
$dbname = 'mlofficial_database';
$dbusername = 'root';
$dbpassword = '';

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>