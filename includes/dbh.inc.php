<?php
$host = 'localhost';
$dbname = 'mlofficial_database';
$dbusername = 'root';
$dbpassword = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $dbusername,
        $dbpassword,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    http_response_code(500);
    die(json_encode(['error' => 'Database connection failed']));
}
?>