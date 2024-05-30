<?php
    session_start();

    function getAffectedIds($deleted) {
        $affected = array();
        foreach ($deleted as $idToDelete) {
            $con = mysqli_connect('127.0.0.1', 'test', '6]5pw[26RM[YHVWa', 'phase2_db', 8889);
            $query = "SELECT post_id FROM post_thread WHERE parent_id = '$idToDelete'";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $affected[] = $row['post_id'];
            }
            $query = "DELETE FROM post WHERE id = '$idToDelete'";
            $result = mysqli_query($con, $query);
            $query = "DELETE FROM thread WHERE id = '$idToDelete'";
            $result = mysqli_query($con, $query);
        }
        return $affected;
    }

    $id = $_POST['id'];
    $affectedIds = getAffectedIds(array($id));

    while (!empty($affectedIds)) {
        $affectedIds = getAffectedIds($affectedIds);
    }

    header("Location: ../html/Blog.php");

?>