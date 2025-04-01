<?php


declare(strict_types= 1);


function get_username(object $pdo, string $username) {
    $query= "SELECT Username FROM tbl_useraccount WHERE Username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();  


    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


function get_email(object $pdo, string $email) {
    $query= "SELECT Email_Address FROM tbl_useraccount WHERE Username = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();  


    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


function set_user(object $pdo, string $email, string $pwd, string $username) {
    $account_number = rand(10000, 99999); // Generate account number


    $_SESSION['Squad_ID'] = $account_number;


    $query = "INSERT INTO tbl_useraccount (Email_Address, Password, Username, Squad_ID)
              VALUES (:email, :pwd, :username, :account_number);"; //Account Number == Squad ID hehe


    $stmt = $pdo->prepare($query);


    $options = [
        'cost' => 12
    ];
    $hashedPWD = password_hash($pwd, PASSWORD_BCRYPT, $options);


    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pwd", $hashedPWD);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":account_number", $account_number);


    $stmt->execute();


    // Return the generated account number
    return $account_number;
}
