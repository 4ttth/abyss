<?php
session_start();
require_once 'dbh.inc.php';
require_once 'signup_model.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if user is admin (additional security)
    if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'Admin') {
        header("Location: /loginPage.php");
        exit();
    }

    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Error handling
    if (empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        header("Location: /Admin User Level/adminModeratorAccounts.php?error=emptyfields");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: /Admin User Level/adminModeratorAccounts.php?error=invalidemail");
        exit();
    } elseif ($password !== $confirm_password) {
        header("Location: /Admin User Level/adminModeratorAccounts.php?error=passwordmismatch");
        exit();
    }

    // Check existing email/username
    try {
        $emailExists = get_email($pdo, $email);
        $usernameExists = get_username($pdo, $username);

        if ($emailExists) {
            header("Location: /Admin User Level/adminModeratorAccounts.php?error=emailtaken");
            exit();
        }
        if ($usernameExists) {
            header("Location: /Admin User Level/adminModeratorAccounts.php?error=usernametaken");
            exit();
        }

        // Insert moderator into tbl_useraccount
        $account_number = rand(10000, 99999);
        $hashedPwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        $sql = "INSERT INTO tbl_useraccount (Email_Address, Password, Username, Squad_ID, Role) 
                VALUES (?, ?, ?, ?, 'Moderator')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $hashedPwd, $username, $account_number]);

        header("Location: /Admin User Level/adminModeratorAccounts.php?success=accountadded");
        exit();

    } catch (PDOException $e) {
        header("Location: /Admin User Level/adminModeratorAccounts.php?error=sqlerror");
        exit();
    }

} else {
    header("Location: /Admin User Level/adminModeratorAccounts.php");
    exit();
}