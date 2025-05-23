<?php
session_start();
require_once 'includes/signup_view.inc.php';
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
    <title>ABYSS — Signup</title>
    <link rel="stylesheet" type="text/css" href="CSS/signupStyle.css">
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
                    <?php
                    if (isset($_SESSION["errors_signup"])) {
                        echo '<div style="margin-top: 15px;" class="alert alert-danger">';
                        foreach ($_SESSION["errors_signup"] as $error) {
                            echo $error . "<br/>";
                        }
                        echo '</div>';
                        unset($_SESSION["errors_signup"]);
                    }
                    ?>

                    <form action="includes/signup.inc.php" method="post">
                        <!-- Email Field -->
                        <div class="form-group mt-3">
                            <label class="form-label title">EMAIL</label>
                            <input type="text" name="email" class="form-control plchldr" placeholder="Enter email" 
                                value="<?php echo isset($_SESSION['signup_email']) ? htmlspecialchars($_SESSION['signup_email']) : ''; ?>">
                            <?php if (isset($_SESSION['errors_signup']['invalid_email'])): ?>
                                <div class="text-danger"><?php echo $_SESSION['errors_signup']['invalid_email']; ?></div>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['errors_signup']['email_used'])): ?>
                                <div class="text-danger"><?php echo $_SESSION['errors_signup']['email_used']; ?></div>
                            <?php endif; ?>
                            <p class="validation">MUST BE A VALID EMAIL</p>
                        </div>

                        <!-- Username Field -->
                        <div class="form-group mt-3">
                            <label class="form-label title">USERNAME</label>
                            <input type="text" name="username" class="form-control plchldr" placeholder="Enter username" 
                                value="<?php echo isset($_SESSION['signup_username']) ? htmlspecialchars($_SESSION['signup_username']) : ''; ?>">
                            <?php if (isset($_SESSION['errors_signup']['username_taken'])): ?>
                                <div class="text-danger"><?php echo $_SESSION['errors_signup']['username_taken']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group mt-3">
                            <label class="form-label title">PASSWORD</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control plchldr" placeholder="Enter password">
                                <button class="btn eye" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <p class="validation">MUST BE 8 CHARACTERS LONG</p>
                            <?php if (isset($_SESSION['errors_signup']['passwordLength_short'])): ?>
                                <div class="text-danger"><?php echo $_SESSION['errors_signup']['passwordLength_short']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group mt-3">
                            <label class="form-label title">CONFIRM PASSWORD</label>
                            <div class="input-group">
                                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control plchldr" placeholder="Confirm password" required>
                                <button class="btn eye" type="button" id="toggleConfirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <?php if (isset($_SESSION['errors_signup']['confirm_password'])): ?>
                                <div class="text-danger"><?php echo $_SESSION['errors_signup']['confirm_password']; ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Display General Errors -->
                        <?php if (isset($_SESSION['errors_signup']['empty_input'])): ?>
                            <div class="alert alert-danger"><?php echo $_SESSION['errors_signup']['empty_input']; ?></div>
                        <?php endif; ?>

                        <!-- Signup Button -->
                        <div class="text-end mt-4">
                            <button type="submit" name="signup" class="btn signupButton">SIGN UP</button>
                            <div class="text">Already have an account? <a href="loginPage.php" class="loginButtonEntry"><u>Login</u></a></div>
                        </div>
                    </form>

                    <?php 
                    // Clear errors and form data after displaying them
                    unset($_SESSION['errors_signup']);
                    unset($_SESSION['signup_email']);
                    unset($_SESSION['signup_username']); 
                    ?>

                    <?php
                    check_signup_errors();
                    ?>

                </div>
            </div>
        </div>
    </div>
    
    <!-- Javascript -->
    <script src="JS/signScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>