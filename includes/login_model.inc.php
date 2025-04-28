<?php

declare(strict_types=1);

// function get_user(object $pdo, string $username) {
//     $query= "SELECT * FROM tbl_useraccount WHERE Username = :username;";
//     $stmt = $pdo->prepare($query);
//     $stmt->bindParam(":username", $username);
//     $stmt->execute();   

//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $result;
// }

function get_user_or_player($pdo, $identifier) {
    $query = "SELECT u.User_ID, u.Username, u.Password, u.Role, u.Squad_ID, 
                     p.Player_ID, p.IGN
              FROM tbl_useraccount u
              LEFT JOIN tbl_playerprofile p ON u.Squad_ID = p.Squad_ID
              WHERE u.Username = :user_ident OR p.IGN = :ign_ident";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':user_ident', $identifier, PDO::PARAM_STR);
    $stmt->bindValue(':ign_ident', $identifier, PDO::PARAM_STR);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}