<?php
session_start();
require_once 'includes/dbh.inc.php';

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Fetch the user based on the token
    $stmt = $pdo->prepare("SELECT * FROM tbl_useraccount WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $email = $user['Email_Address']; // Automatically get the email from the token
        $stmt = $pdo->prepare("UPDATE tbl_useraccount SET verified = 1, token = NULL WHERE Email_Address = ?");
        $stmt->execute([$email]);

        // Set session variables for the user
        $_SESSION['user'] = [
            'username' => $user['Username'],
            'Squad_ID' => $user['Squad_ID'],
            'verified' => 1
        ];

        $_SESSION['success'] = "Email verified successfully!";
        header("Location: squadCreation.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: verifyEmail.php");
        exit();
    }
}

// Handle token submission via the form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];

    // Fetch the user based on the token
    $stmt = $pdo->prepare("SELECT * FROM tbl_useraccount WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $email = $user['Email_Address']; // Automatically get the email from the token
        $stmt = $pdo->prepare("UPDATE tbl_useraccount SET verified = 1, token = NULL WHERE Email_Address = ?");
        $stmt->execute([$email]);

        // Set session variables for the user
        $_SESSION['user'] = [
            'username' => $user['Username'],
            'Squad_ID' => $user['Squad_ID'],
            'verified' => 1
        ];

        $_SESSION['success'] = "Email verified successfully!";
        header("Location: squadCreation.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5PJVHXE14X"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5PJVHXE14X');
</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
</head>
<body>
    <h1>Email Verification</h1>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>Token:</label>
        <input type="text" name="token" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>