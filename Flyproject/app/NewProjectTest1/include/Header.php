<?php
require_once 'CheckLogin.php';
test_only_include(true);
global $current_user;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="boxicons/css/boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css\RegisterCss.css">
    <title><?php if (isset($html_title)) echo $html_title?></title>
</head>

<body>
 <div class="wrapper">
    <nav class="nav">
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="index.php" class="link <?php if(isset($home_active) && $home_active) echo "active"?>">Home</a></li>
                <?php
                if (!is_null($current_user) && $current_user->enabled()) {
                    echo '<li><a href="BookFlight.php" class="link ' . ((isset($book_flight_active) && $book_flight_active) ? "active" : "") . '">Book Flight</a></li>';
                    if ($current_user->admin()) {
                        echo '<li><a href="Users.php" class="link ' . ((isset($users_active) && $users_active) ? "active" : "") . '">Users</a></li>';
                    }
                    if ($current_user->super_admin()) {
                        echo '<li><a href="Planes.php" class="link ' . ((isset($planes_active) && $planes_active) ? "active" : "") . '">Planes</a></li>';
                    }
                }
                ?>
                <li><a href="About.php" class="link <?php if(isset($about_active) && $about_active) echo "active"?>">About</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <?php
            if (is_null($current_user)) {
                echo '<button class="btn" id="loginBtn" onclick="login()">Sign In</button>
<button class="btn right-btn" id="registerBtn" onclick="register()">Sign Up</button>';
            } else {
                echo '<button class="btn" id="welcomeUserBtn">Welcome, ' . $current_user->firstname() . '!</button>
<button class="btn right-btn" id="logoutBtn" onclick="logout()">Sign out</button>';
            }
            ?>
        </div>
    </nav>

    <!----------------------------- Form box ----------------------------------->    
    <div class="form-box" id="form-box">

        <!------------------- login form -------------------------->
       <div class="login-container" id="login">
            <div class="top">
                <span>Don't have an account? <a href="#" onclick="register()">Sign Up</a></span>
                <header>Login</header>
            </div>
            <form action="Login.php" method="post" onsubmit="return validateLogin()">
                <div class="input-box">
                    <input type="email" class="input-field" id="email_login" name="email" placeholder="Email" oninput="setCustomValidity('')" required>
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" id="password_login" name="password" placeholder="Password" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-box">
                    <input type="hidden" name="return_url" value="<?php echo current(explode("?", htmlspecialchars($_SERVER['REQUEST_URI']))); ?>">
                </div>
                <div class="input-box">
                    <input type="submit" class="submit" name="login" value="Sign In">
                </div>
            </form>
        </div>

        <!------------------- registration form -------------------------->

        <div class="register-container" id="register">
            <div class="top">
                <span>Have an account? <a href="#" onclick="login()">Login</a></span>
                <header>Sign Up</header>
            </div>
            <form action="Signup.php" method="post" onsubmit="return validateRegister()">
                <div class="register-top-line">
                    <div class="input-box flex1">
                        <input type="text" class="input-field" id="firstname_register" name="firstname" placeholder="Firstname" minlength="2" oninput="setCustomValidity('')" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box flex2">
                        <input type="text" class="input-field" id="lastname_register" name="lastname" placeholder="Lastname" minlength="2" oninput="setCustomValidity('')" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box flex3">
                        <input type="number" name="age" min="18" max="70" class="input-field" id="age_register" placeholder="Age" required>
                        <i class="bx bx-user"></i>
                    </div>
                </div>
                <div class="input-box">
                    <input type="email" class="input-field" id="email_register" name="email" placeholder="Email" oninput="setCustomValidity('')" required>
                    <i class="bx bx-envelope"></i>
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" id="password_register" name="password" placeholder="Password" minlength="6" maxlength="20" oninput="setCustomValidity('')" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" id="password_re_register" name="password_re" placeholder="Retype Password" minlength="6" maxlength="20" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-box">
                    <input type="submit" class="submit">
                </div>
            </form>
        </div>
    </div>
    <div class="content" id="content">