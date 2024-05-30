<!-- log out -->

<?php
    session_start();
    $con = mysqli_connect('127.0.0.1', 'test', '6]5pw[26RM[YHVWa', 'phase2_db', 8889);
    if(isset($_SESSION['user_id']))
    {
        unset($_SESSION['user_id']);
        echo "You have been logged out!";
        header("Location: ../html/Vera_Malkova.php");
        die;
    }
    echo "You are not logged in!";
    echo "Session ".isset($_SESSION['user_id']);
    die;
?>