<?php
    session_start();
    $con = mysqli_connect('127.0.0.1', 'test', '6]5pw[26RM[YHVWa', 'phase2_db', 8889);
    function console_log($output, $with_script_tags = true)
    {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags)
        {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
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
    <link rel="stylesheet" href="../css/Blog.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Cuprum:ital,wght@0,400..700;1,400..700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Cardo:ital,wght@0,400;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Cuprum:ital,wght@0,400..700;1,400..700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

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
    <div class="center">
        <?php
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                file_put_contents('../json/user.json', $user_id);
                if ($user_id == 0) {
                    echo '<a href="#AddPost" class="button"><button type="button"><span></span>ADD POST</button></a>';
                }
            } else {
                file_put_contents('../json/user.json', '-1');
                echo '<a href="Vera_Malkova.php#LogIn" class="button"><button type="button"><span></span>LOG IN</button></a>';
            }
        ?>
        <article>
            <section id="Blog">
                <?php
                    function bubble_sort($requested_id) {
                        global $con;
                        $times = array();
                        $posts = array();

                        // Fetch times from post and post_thread tables
                        $query = "SELECT post.timestamp
                                    FROM post
                                    INNER JOIN post_thread ON post.id = post_thread.post_id
                                    WHERE post_thread.parent_id = '$requested_id'";
                        $result = mysqli_query($GLOBALS['con'], $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $times[] = $row['timestamp'];
                        }

                        // Sort the times array in descending order
                        for ($i = 0; $i < count($times) - 1; $i++) {
                            for ($j = 0; $j < count($times) - $i - 1; $j++) {
                                if (strtotime($times[$j]) < strtotime($times[$j + 1])) {
                                    $temp = $times[$j];
                                    $times[$j] = $times[$j + 1];
                                    $times[$j + 1] = $temp;
                                }
                            }
                        }

                        // Fetch posts based on the sorted times
                        foreach ($times as $time) {
                            $query = "SELECT post.id
                                        FROM post
                                        INNER JOIN post_thread ON post.id = post_thread.post_id
                                        WHERE post_thread.parent_id = '$requested_id' AND post.timestamp = '$time'";
                            $result = mysqli_query($GLOBALS['con'], $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $posts[] = $row['id'];
                            }
                        }

                        return $posts;
                    }

                    $main_posts = bubble_sort(0);
                    
                    function drawPosts($posts) {
                        $posts_info = array();
                        foreach ($posts as $postId) {
                            // Fetch post details from post table
                            $query = "SELECT post.user_id, post.timestamp, post.title, post.comment
                                        FROM post
                                        WHERE post.id = '$postId'";
                            $result = mysqli_query($GLOBALS['con'], $query);
                            $row = mysqli_fetch_assoc($result);
                            $userId = $row['user_id'];
                            $timestamp = $row['timestamp'];
                            $title = $row['title'];
                            $comment = $row['comment'];

                            // Fetch user name from users table
                            $query = "SELECT users.name
                                        FROM users
                                        WHERE users.id = '$userId'";
                            $result = mysqli_query($GLOBALS['con'], $query);
                            $row = mysqli_fetch_assoc($result);
                            $name = $row['name'];

                            // Extract day, year, time and month from time
                            $day = date('d', strtotime($timestamp));
                            $year = date('Y', strtotime($timestamp));
                            $time = date('H:i', strtotime($timestamp));
                            $month = date('F', strtotime($timestamp));

                            // Check if post has replies
                            $replies = hasReplies($postId);

                            // Create post info array
                            $post_info = array(
                                'id' => $postId,
                                'name' => $name,
                                'day' => $day,
                                'year' => $year,
                                'time' => $time,
                                'month' => $month,
                                'title' => $title,
                                'comment' => $comment,
                                'replies' => $replies
                            );

                            // Add post info to posts info array
                            $posts_info[] = $post_info;
                        }

                        // Encode posts info array into JSON file
                        $json_data = json_encode($posts_info);
                        file_put_contents('../json/posts.json', $json_data);

                        // Run JavaScript file
                        echo '<script type="module" src="../js/Show_divs.js"></script>';
                    }

                    function hasReplies($postId) {
                        $ids = bubble_sort($postId);
                        $replies = array();
                        foreach ($ids as $id) {
                            // Fetch reply details from post and users tables
                            $query = "SELECT post.user_id, post.timestamp, post.title, post.comment
                                        FROM post
                                        WHERE post.id = '$id'";
                            $result = mysqli_query($GLOBALS['con'], $query);
                            $row = mysqli_fetch_assoc($result);
                            $userId = $row['user_id'];
                            $time = $row['timestamp'];
                            $title = $row['title'];
                            $comment = $row['comment'];

                            // Fetch user name from users table
                            $query = "SELECT users.name
                                        FROM users
                                        WHERE users.id = '$userId'";
                            $result = mysqli_query($GLOBALS['con'], $query);
                            $row = mysqli_fetch_assoc($result);
                            $name = $row['name'];

                            // Extract day and month from time
                            $day = date('d', strtotime($time));
                            $month = date('F', strtotime($time));
                            $year = date('Y', strtotime($time));
                            $time = date('H:i', strtotime($time));

                            // Check if reply has replies
                            $reply_replies = hasReplies($id);

                            // Create reply array
                            $reply = array(
                                'id' => $id,
                                'name' => $name,
                                'day' => $day,
                                'month' => $month,
                                'year' => $year,
                                'time' => $time,
                                'title' => $title,
                                'comment' => $comment,
                                'replies' => $reply_replies
                            );

                            // Add reply to replies array
                            $replies[] = $reply;
                        }

                        // Encode replies array into JSON file
                        $json_data = json_encode($replies);
                        $file_path = '../json/replies' . $postId . '.json';
                        file_put_contents($file_path, $json_data);

                        return $replies;
                    }

                    drawPosts($main_posts);
                    
                ?>
        </article>
        <div class="overlay" id="AddPost">
            <aside class="popup">
                <div class="input">
                    <a href="#" class="close">&times;</a>
                    <h2>ADD POST</h2>
                    <form action="../php/addPost.php" method="POST">
                        <input id = "title" type="text" name="postTitle" placeholder="Title">
                        <p id="error"></p>
                        <input id = "comment" type="text" name="postComment" placeholder="Comment">
                        <p id="error"></p>
                        <?php
                            // Get the name of the user with the same 'id' as the 'user_id' of the current session
                            $user_id = $_SESSION['user_id'];
                            $query = "SELECT name FROM users WHERE id = '$user_id'";
                            $result = mysqli_query($con, $query);
                            $row = mysqli_fetch_assoc($result);
                            $name = $row['name'];

                            // Get the current date and time in UTC
                            $datetime = gmdate('d F Y | H:i');

                            // Create the input field
                            $input = "<input type='hidden' id='user_date_time' name='user_date_time' value='$name | $datetime' UTC>";
                            echo $input;
                        ?>
                        <div class="buttonRow">
                            <button id="post">Post</button>
                            <a class="button" href="#postPreview">
                                <button id="preview">Preview</button>
                            </a>
                            <button id="clear">Clear</button>
                        </div>
                    </form>
                </div>
            </aside>
        </div>
    </div>
    <footer>
        <p>&copy 2023 Vera Malkova</p>
    </footer>
    <script src="../js/Add_post.js"></script>
</body>
</html>