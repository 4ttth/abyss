<?php
session_start();
require_once '/includes/login_view.inc.php';
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
    <div class="introScreen">
        <div class="loadingAnimation"></div>
    </div>

    <div class="pageContent hiddenContent">
        <!-- Navigation Bar -->
        <div class="container-fluid">        
            <div class="row">
                <div class="container-fluid navigationBar">
                    <!-- Logo Layer -->
                    <div class="logoLayer">
                        <!-- Logo and Name -->
                        <a class="navbar-brand" href="index.php">
                            <img src="IMG/essentials/whiteVer.PNG" class="logoPicture" alt="ABYSS">
                            <div class="logoText">abyss</div>
                        </a>
                        
                        <form class="searchBar" action="guestSearchResultsPage.php" method="GET">
                            <input class="searchInput" type="search" name="query" placeholder="Search Squads" aria-label="Search">
                            <button class="searchButton" type="submit">
                                <img src="IMG/essentials/whiteVer.PNG" alt="Search">
                            </button>
                        </form>
                    
                        <!-- Account Logo Button -->
                        <button class="accountLogo" data-bs-toggle="modal" data-bs-target="#loginSignupModal">
                            <i class="bi bi-person-circle"></i>
                        </button>                        
                    
                        <!-- Navbar Toggle Button -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="guestDiscoverPage.php">DISCOVER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aboutUsPage.php">ABOUT US</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

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

                    <!-- Error Alert -->
                    <?php if (isset($_SESSION['error_login'])) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $_SESSION['error_login'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error_login']); ?>
                    <?php endif; ?>

                    <form action="/includes/login.inc.php" method="post">
                        <!-- Username Field -->
                        <div class="form-group mt-3">
                            <label class="form-label title">USERNAME</label>
                            <input type="text" name="username" class="form-control plchldr" placeholder="Enter username" 
                                value="<?php echo isset($_SESSION['login_username']) ? htmlspecialchars($_SESSION['login_username']) : ''; ?>" required>
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

                    <?php check_login_errors(); ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="JS/logScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>