<?php
    require_once 'includes/config_session.inc.php';
    require_once 'includes/login_view.inc.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABYSS — Login</title>
    <link rel="stylesheet" type="text/css" href="CSS/loginStyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="IMG/essentials/whiteVer.PNG">
</head>

<body class="customPageBackground">
    <div class="container vh-100 d-flex align-items-center">
        <div class="row justify-content-end w-100">
            <div class="col-6">
                <div class="backButton">
                    <a href="index.php">
                        <i class="bi bi-box-arrow-left backButton"></i>
                    </a>
                </div>

                <div class="logo">
                    <a class="navbar-brand" href="index.php">
                        <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                        <div class="logoText">abyss</div>
                    </a>
                </div>

                <form action="includes/login.inc.php" method = "post">
                    <!-- Username Field -->
                    <div class="form-group mt-3">
                        <label class="form-label title">USERNAME</label>
                        <input type="text" name="username" class="form-control plchldr" placeholder="Enter username" required>
                    </div>
    
                    <!-- Password Field -->
                    <div class="form-group mt-3">
                        <label class="form-label title">PASSWORD</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control plchldr" placeholder="Enter password" required>
                            <button class="btn eye" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
    
                    <!-- Login Button -->
                    <div class="text-end mt-4">
                        <button type="submit" class="btn loginButton">LOG IN</button>
                        <div class="text">Don't have an account yet? <a href="signupPage.php" class="loginButtonEntry">Sign up</a></div>
                    </div>
                </form>

                <?php
                check_login_errors();
                ?>

            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="JS/logScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>