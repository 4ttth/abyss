<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        $errors = [];

        // Validate empty fields
        if (is_input_empty($username, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        // Fetch user data
        $result = get_user_or_player($pdo, $username);

        // Validate credentials
        if (is_username_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect Login Info!";
        } else {
            if (!password_verify($pwd, $result["Password"])) {
                $errors["login_incorrect"] = "Incorrect Login Info!";
            }
        }

        // Handle errors
        if ($errors) {
            $_SESSION["error_login"] = reset($errors);
            header("Location: ../loginPage.php");
            die();
        }

        // Regenerate session ID
        session_regenerate_id(true);

        // Set session variables
        $_SESSION['user'] = [
            'User_ID' => $result["User_ID"],
            'Username' => htmlspecialchars($result["Username"]),
            'Role' => $result["Role"],
            'Squad_ID' => $result["Squad_ID"] ?? null,
            'is_player' => is_player_login($result),
            'Player_ID' => $result["Player_ID"] ?? null
        ];

        // Check penalty status
        try {
            $stmt = $pdo->prepare("SELECT Status FROM tbl_penalties WHERE Squad_ID = ?");
            $stmt->execute([$_SESSION['user']['Squad_ID']]);
            $penaltyStatus = $stmt->fetchColumn();
            $_SESSION["penalized"] = ($penaltyStatus === 'Active');
        } catch (PDOException $e) {
            die("Error checking penalty status: " . $e->getMessage());
        }

        // Redirect based on role
        if ($_SESSION['user']['is_player']) {
            header("Location: ../playerDashboard.php");
        } else {
            // Keep your existing role-based redirection
            switch ($_SESSION['user']['Role']) {
                case 'Admin':
                    header("Location: ../Admin User Level/adminIndex.php");
                    break;
                case 'Moderator':
                    header("Location: ../Moderator User Level/modIndex.php");
                    break;
                default:
                    if ($_SESSION["penalized"]) {
                        $_SESSION['error_login'] = "You are penalized!";
                        header("Location: ../loginPage.php");
                    } else {
                        header("Location: ../userHomepage.php");
                    }
                    break;
            }
        }

        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../loginPage.php");
    die();
}