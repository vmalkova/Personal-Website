<!-- login -->

<?php
    session_start();
    if($con = mysqli_connect('127.0.0.1', 'test', '6]5pw[26RM[YHVWa', 'phase2_db', 8889))
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //something was posted
            $email = $_POST['email'];
            $password = $_POST['password'];

            if(!empty($email) && !empty($password))
            {
                //read from database
                $query = "SELECT * FROM users WHERE email = '$email' limit 1";
                $result = mysqli_query($con, $query);

                if($result)
                {
                    if($result && mysqli_num_rows($result) > 0)
                    {
                        $user_data = mysqli_fetch_assoc($result);
                        if($user_data['password'] === $password)
                        {
                            $_SESSION['user_id'] = $user_data['id'];
                            $_SESSION['user_name'] = $user_data['name'];
                            $_SESSION['user_email'] = $user_data['email'];
                            echo "Session ".$user_data['user_id'];
                            header("Location: ../html/Vera_Malkova.php");
                            die;
                        }
                    }
                }
                echo "Wrong email or password!";
                header("Location: ../html/Vera_Malkova.php#LogIn");
                die;
            }
        }
    }
?>