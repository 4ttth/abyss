<?php
session_start();
$_SESSION['user'] = [
    'username' => $username,
    'account_Number' => $accountNumber
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"] ?? '';

    try {
        require_once 'dbh.inc.php';
        require_once 'signup_contr.inc.php';
        require_once 'signup_model.inc.php';

<<<<<<< Updated upstream
        // ERROR HANDLERS Development 1 Commit Try
=======
        // ERROR HANDLERS Development 1 Commit Tryess
>>>>>>> Stashed changes
        $errors = [];

        if (is_input_empty($username, $pwd, $email)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
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

        require_once 'config_session.inc.php';

        // IF ERROR, BABALIK SA INDEX (Need ng Prompt)
        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            header("Location: ../signupPage.php");
            die();
        }

        // Create the user and capture the generated account number.
        $accountNumber = create_user($pdo, $email, $pwd, $username);

        // Store username and account number in the session.
        $_SESSION['user'] = [
            'username' => $username,
            'account_Number' => $accountNumber
        ];

        header("Location: ../squadCreation.php?signup=success&username=" . urlencode($username));

        $pdo = null;
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
?>