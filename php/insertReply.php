<?php
    session_start();
    $con = mysqli_connect('127.0.0.1', 'test', '6]5pw[26RM[YHVWa', 'phase2_db', 8889);

    // Get the largest 'id' from the 'post' table
    $query = "SELECT MAX(id) AS max_id FROM post";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $largest_id = $row['max_id'];

    // Calculate the new 'post_id'
    $new_post_id = $largest_id + 1;

    // Get the current session's user_id
    $user_id = $_SESSION['user_id'];

    // Get the comment text from the element with id 'replyComment'
    $comment = $_POST['replyComment'];

    // Get the current timestamp (date and time in UTC)
    $timestamp = gmdate('Y-m-d H:i:s');

    // Insert into the 'post' table
    $query = "INSERT INTO post (id, user_id, title, comment, timestamp) VALUES ('$new_post_id', '$user_id', '', '$comment', '$timestamp')";
    mysqli_query($con, $query);

    // Check if 'pid' exists in the 'thread' table
    $pid = $_POST['pid'];
    $query = "SELECT id FROM thread WHERE id = '$pid'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        // Insert into the 'thread' table
        $query = "INSERT INTO thread (id, timestamp) VALUES ('$pid', '$timestamp')";
        mysqli_query($con, $query);
    }

    // Insert into the 'post_thread' table
    $query = "INSERT INTO post_thread (post_id, parent_id) VALUES ('$new_post_id', '$pid')";
    $result = mysqli_query($con, $query);

    // Redirect to '../html/Blog.php'
    header('Location: ../html/Blog.php');
    exit;
?>