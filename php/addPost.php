<?php
    session_start();
    $con = mysqli_connect('127.0.0.1', 'test', '6]5pw[26RM[YHVWa', 'phase2_db', 8889);

    // Find the smallest 'id' that isn't used yet in the table 'post'
    $query = "SELECT MIN(id + 1) AS new_id FROM post WHERE NOT EXISTS (SELECT * FROM post p2 WHERE p2.id = post.id + 1)";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $new_post_id = $row['new_id'];

    // Insert into the table 'post'
    $title = ucfirst($_POST['postTitle']);
    $comment = ucfirst($_POST['postComment']);
    $time = gmdate('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id'];

    $title = str_replace("'", "''", $title);
    $comment = str_replace("'", "''", $comment);

    $query = "INSERT INTO post (id, user_id, title, comment, timestamp) VALUES ('$new_post_id', '$user_id', '$title', '$comment', '$time')";
    $result = mysqli_query($con, $query);

    // Insert into the 'post_thread' table
    $query = "INSERT INTO post_thread (post_id, parent_id) VALUES ('$new_post_id', '0')";
    $result = mysqli_query($con, $query);

    // Change location to '../html/Blog.php'
    header('Location: ../html/Blog.php');
    exit;

?>