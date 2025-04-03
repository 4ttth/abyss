<?php
$config = include('config.php');
unset($_SESSION['Error']);

if(!isset($_SESSION["user_id"])){
    $_SESSION['Error'] = 'You have been inactive for too long. We have to log you out for security reasons.';
    header("Location: includes/error.php");
    exit;
}
?>

<!-- HTML for the modal -->

