<?php

include "config.php";
if ($_SESSION["user_role"] == 0) {
    header("Location: http://localhost/news-blog/admin/post.php");
}
$user_id = $_GET['id'];
$sql = "DELETE FROM user WHERE user_id = '{$user_id}'";
$result = mysqli_query($conn, $sql) or die("Query Failed");

header("Location: http://localhost/news-blog/admin/users.php");
