<?php
    session_start();
    if($con = mysqli_connect('127.0.0.1', 'test', '6]5pw[26RM[YHVWa', 'phase2_db', 8889))
    {
        echo "success";
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //something was posted
            echo "post";
            $name = $_POST['user_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if(!empty($name) && !empty($password) && !is_numeric($name))
            {
                //save to database
                $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

                mysqli_query($con, $query);
                header("Location: ../html/Vera_Malkova.php#LogIn");
            }
        }
    }
    echo "fail";
    die;
?>