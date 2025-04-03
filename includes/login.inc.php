<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        //ERROR HANDLERS
        $errors = [];

        if (is_input_empty($username, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $username);

        if (is_username_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect Login Info!";
        }

        if (is_username_wrong($result) && is_password_wrong($pwd, $result["pwd"])) {
            $errors["login_incorrect"] = "Incorrect Login Info!";
        }


        require_once 'config_session.inc.php';

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;

            header("Location: ../index.php");
            die();
        }

        session_regenerate_id(true); //NEWLY ADDED*****

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["User_ID"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["User_ID"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["user_role"] = $result["Role"]; //NEWLY ADDED*****

        $_SESSION["last_regeneration"] = time();

    // ADD NG IF NAKUHA MO IS ADMIN, IHHEADER SA ADMIN PAGE, MODERATOR ETC ETC
        switch ($result["Role"]) {
            case 'Admin':
                $_SESSION['user_role'] = 'Admin';
                $_SESSION['user']['User_ID'] = $result['User_ID'];
                header("Location: ../Admin User Level/adminIndex.php");
                break;
            case 'Moderator':
                $_SESSION['user_role'] = 'Moderator';
                $_SESSION['user']['User_ID'] = $result['User_ID'];
                header("Location: ../Moderator User Level/modIndex.php");
                break;
            default:
                $_SESSION['user_role'] = 'User';
                $_SESSION['user']['Squad_ID'] = $result['Squad_ID'];
                $_SESSION['user']['User_ID'] = $result['User_ID'];
                header("Location: ../userHomepage.php");
        }
        $pdo = null;
        $statement = null;

        die();
    } catch (PDOException $e) {
        die ("Query failed: " . $e->getMessage());
    }
}
else {
    header ("Location: ../loginPage.php"); //test
    die();
}

?>