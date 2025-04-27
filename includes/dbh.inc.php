<?php
$config = include('config.php');
$host = $config['DB_HOST'];
$dbname = $config['DB_NAME'];
$dbusername = $config['DB_USERNAME'];
$dbpassword = $config['DB_PASSWORD'];

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
    try {
        // Create a new PDO instance
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $dbusername,
            $dbpassword,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        
        // Step 1: Expire Penalties
        $expireSql = "UPDATE tbl_penalties 
                      SET Status = 'Expired'
                      WHERE End_Date <= NOW() 
                        AND Status = 'Active'";
        $stmt1 = $pdo->prepare($expireSql);
        $stmt1->execute();
        
        // Step 2: Update Squad Profiles Based on Active Penalties
        $updateSql = "UPDATE tbl_squadprofile s
                      LEFT JOIN (
                          SELECT DISTINCT Squad_ID
                          FROM tbl_penalties
                          WHERE Status = 'Active'
                      ) p ON s.Squad_ID = p.Squad_ID
                      SET s.isPenalized = IF(p.Squad_ID IS NOT NULL, 1, 0)";
        $stmt2 = $pdo->prepare($updateSql);
        $stmt2->execute();
    
    } catch (PDOException $e) {
        // Log error or notify
        error_log("Updating error on penalization: " . $e->getMessage());
        //echo "An error occurred. Check your logs.";
    }
    
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    http_response_code(500);
    die(json_encode(['error' => 'Database connection failed']));
}
?>