<?php
// Ensure no output before headers
session_start();
header('Content-Type: application/json');
require_once 'dbh.inc.php';

try {
    // Validate session
    if (!isset($_SESSION['user'])) {
        throw new Exception("Authentication required");
    }

    // Fetch fresh user data
    $stmt = $pdo->prepare("SELECT * FROM tbl_useraccount WHERE User_ID = ?");
    $stmt->execute([$_SESSION['user']['User_ID']]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user_data) {
        throw new Exception("User not found");
    }

    // Validate squad membership
    if (empty($user_data['Squad_ID'])) {
        throw new Exception("User is not part of a squad");
    }

    // Validate range input
    $custom_range = filter_var(
        $_GET['range'] ?? 10,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1, 'max_range' => 50, 'default' => 10]] //Fixed Range ^-^
    );

    // Get squad data
    $squad_id = $user_data['Squad_ID'];
    $stmt = $pdo->prepare("SELECT Average_Star FROM tbl_squadprofile WHERE Squad_ID = ?");
    $stmt->execute([$squad_id]);
    $user_squad = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user_squad) {
        throw new Exception("Current squad not found");
    }

    // Calculate star range
    $user_average_star = (float)$user_squad['Average_Star'];
    $min_star = $user_average_star - $custom_range;
    $max_star = $user_average_star + $custom_range;

    // Get matching squads
    $stmt = $pdo->prepare("SELECT 
        Squad_ID, Squad_Acronym, Squad_Name, 
        Squad_Level, Squad_Description, Average_Star
        FROM tbl_squadprofile 
        WHERE Average_Star BETWEEN ? AND ? 
        AND Squad_ID != ?
        ORDER BY Average_Star DESC");
        
    $stmt->execute([$min_star, $max_star, $squad_id]);
    $squads = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'squads' => $squads,
        'current_star' => $user_average_star,
        'range_used' => $custom_range
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
exit();
?>