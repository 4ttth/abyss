<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: ../adminModeratorAccounts.php?error=unauthorized");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $message = $_POST['message_body'];
    $adminId = $_SESSION['user_id'];

    if (empty($subject) || empty($message)) {
        header("Location: ../adminModeratorAccounts.php?error=emptyfields");
        exit();
    }

    $sql = "INSERT INTO tbl_admin_notes (Admin_ID, Subject, Message) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$adminId, $subject, $message])) {
        header("Location: ../adminModeratorAccounts.php?success=noteadded");
    } else {
        header("Location: ../adminModeratorAccounts.php?error=sqlerror");
    }
    exit();
} else {
    header("Location: ../adminModeratorAccounts.php");
    exit();
}