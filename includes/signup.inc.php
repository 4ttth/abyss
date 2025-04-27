<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"] ?? '';
    try {
        require_once 'dbh.inc.php';
        require_once 'signup_contr.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'sendEmail.inc.php';

        $errors = [];
        // Validate empty fields
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used!";
        }
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken!";
        }
        if (is_email_registered($pdo, $email)) {
            $errors["email_used"] = "Email already registered!";
        }
        if (is_passwordLength_short($pdo, $pwd)) {
            $errors["passwordLength_short"] = "Password is too short!";
        }
        if (is_password_not_same($pwd, $confirmPassword)) {
            $errors["confirm_password"] = "Passwords do not match!";
        }

        // IF ERROR, REDIRECT BACK TO SIGNUP PAGE
        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            header("Location: /signupPage.php");
            die();
        }

        // Create the user and capture the generated account number.
        $accountNumber = set_user($pdo, $email, $pwd, $username);

        // Generate a unique token
        do {
            $token = md5(uniqid(rand(), true));
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_useraccount WHERE token = ?");
            $stmt->execute([$token]);
            $tokenExists = $stmt->fetchColumn() > 0;
        } while ($tokenExists);

        // Store the token and set verified to false
        $stmt = $pdo->prepare("UPDATE tbl_useraccount SET token = ?, verified = 0 WHERE Email_Address = ?");
        $stmt->execute([$token, $email]);
        
        // Send verification email
        $config = include('config.php');
        $encodedemail = base64_encode($email);
        $encodedusername = base64_encode($username);
        $encodedaccountNumber = base64_encode(strval($accountNumber));
        $verificationLink = "https://" . $config['HOST_NAME'] . "/verifyEmail.php?token=$token" . "&rava=$encodedemail" . "&pau=$encodedusername" . "&sel=$encodedaccountNumber";
        $subject = "Verify Your Email Address";
        $body = "
            <h1>Email Verification</h1>
            <p>Thank you for signing up! Please verify your email address by clicking the link below:</p>
            <a href='$verificationLink'>Click me!</a>
            <p>If the link doesn't work, you can copy the token below:</p>
            <p><strong>Token:</strong> $token</p>
        ";
        sendEmailToSquad($pdo, $accountNumber, $subject, $body);

        $_SESSION['success'] = "Signup successful! Please verify your email.";
        header("Location: /index.php");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: /index.php");
    die();
}
?>