<?php

session_start();
session_unset();
session_destroy();
$_SESSION['success'] = "Player successfully added!";
header("Location: /index.php");
die();
?>