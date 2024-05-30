<?php
    session_start();
    $con = mysqli_connect('127.0.0.1', 'test', '6]5pw[26RM[YHVWa', 'phase2_db', 8889);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Project</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/All_pages.css" media="screen and (min-width: 639px)"> 
    <link rel="stylesheet" href="../css/All_pages_Mobile.css" media="screen and (max-width: 638px)">
    <link rel="stylesheet" href="../css/Vera_Malkova.css" media="screen and (min-height: 629px) and (min-width: 639px)">
    <link rel="stylesheet" href="../css/Vera_Malkova_Short.css" media="screen and (max-height: 628px), screen and (max-width:638px)">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Cuprum:ital,wght@0,400..700;1,400..700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="banner">
        <div class="navbar">
            <a href="Vera_Malkova.php"><img src="../images/logo.png" class="logo"></a>
            <ul>
                <li><a href="About_me_Contact.html">About me</a></li>
                <li><a href="Blog.php">Blog</a></li>
                <li><a href="About_me_Contact.html">Contact</a></li>
                <li><a href="Education_and_qualifications_Experience.html">Education & Qualifications</a></li>
                <li><a href="Education_and_qualifications_Experience.html">Experience</a></li>
                <li><a href="Skills_and_achievements_Portfolio.html">Portfolio</a></li>
                <li><a href="Skills_and_achievements_Portfolio.html">Skills & Achievements</a></li>
            </ul>
        </div>
    </div>
    <div class="home">
        <h1>
            VERA MALKOVA
        </h1>
        <p>Computer Science student at Queen Mary University of London. <br> Welcome to my portfolio!</p>
        <?php
            if(isset($_SESSION['user_id']))
            {
                echo "<a href='#LogOut' class='button'>
                        <button type='button'><span></span>LOG OUT</button>
                    </a>";
            }
            else
            {
                echo "<a href='#LogIn' class='button'>
                        <button type='button'><span></span>LOG IN</button>
                    </a>";
            }
        ?>
        <a href='blog.php' class='button'>
            <button type='button'><span></span>BLOG</button>
        </a>
    </div>
    <footer>
        <p>&copy 2023 Vera Malkova</p>
    </footer>
    <div class="overlay" id="LogOut">
        <aside class="popup">
            <a href="#" class="close">&times;</a>
            <h2>LOG OUT</h2>
            <form action="../php/logout.php" method="post" name="LogOut">
                <p>
                    Hi <?=$_SESSION['user_name']?>,
                    <br>
                    Are you sure you want to log out?
                </p>
                <p>
                    Once you log out, you won't be able to comment on
                    <a href="Blog.php">blog posts</a>.
                </p>
                <p>
                    But you can always log back in!
                </p>
                <div class="submit">
                    <input id="logoutButton" type="submit" value="Log out"></input>
                </div>
            </form>
        </aside>
    </div>
    <div class="overlay" id="LogIn">
        <aside class="popup">
            <a href="#" class="close">&times;</a>
            <h2>LOG IN</h2>
            <form action="../php/login.php" method="post" name="LogIn">
                <label>Email</label>
                <div class="input">
                    <input id="email" type="email" placeholder="Email" name="email">
                    <i class='bx bx-envelope' ></i>
                </div>
                <label>Password</label>
                <div class="input">
                    <input id="password" type="password" placeholder="Password" name="password">
                    <i class='bx bx-lock' ></i>
                </div>
                <div class="submit">
                    <input id="loginButton" type="submit" value="Log in"></input>
                </div>
                <p>
                    Forgot password?
                    <a href="#SignUp">Sign up here</a>
                </p>
            </form>
        </aside>
    </div>
    <div class="overlay" id="SignUp">
        <aside class="popup">
            <a href="#" class="close">&times;</a>
            <h2>Sign up</h2>
            <form action="../php/signup.php" method="post">
                <label>Name</label>
                <div class="input">
                    <input id="newName" type="text" placeholder="Name" name="user_name">
                    <i class='bx bx-envelope' ></i>
                </div>
                <label>Email</label>
                <div class="input">
                    <input id="newEmail" type="email" placeholder="Email" name="email">
                    <i class='bx bx-envelope' ></i>
                </div>
                <label>Password</label>
                <div class="input">
                    <input id="newPassword" type="password" placeholder="Password" name="password">
                    <i class='bx bx-lock' ></i>
                </div>
                <label>Confirm password</label>
                <div class="input">
                    <input id="confirmPassword" type="password" placeholder="Confirm Password" name="confirm password">
                    <i class='bx bxs-lock'></i>
                </div>
                <div class="submit">
                    <input id="signupButton" type="submit" value="Sign Up"></input>
                </div>
                <p>
                    Already have an account?
                    <a href="#LogIn">Log in here</a>
                </p>
            </form>
        </aside>
    </div>
    <script src="../js/Vera_Malkova.js"></script>
</body>
</html>