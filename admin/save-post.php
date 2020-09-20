<?php

include "config.php";

if (isset($_FILES['fileToUpload'])) {
    $error = [];
    $file_name = $_FILES["fileToUpload"]["name"];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $tmp = explode('.', $file_name);
    $file_ext = end($tmp);
    // die();
    $extensions = ['jpeg', 'jpg', 'png'];

    if (in_array($file_ext, $extensions) === false) {
        $error[] = "This extension file is not allowed. Please Choose a JPG or PNG file";
    }

    if ($file_size > 2097152) {
        $error[] = "File limit max 2MB";
    }

    if (empty($error) === true) {
        move_uploaded_file($file_tmp, 'upload/' . $file_name);
    } else {
        print_r($error);
        die();
    }
}

$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$description = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$date = date("d M, Y");
session_start();
$author = $_SESSION['user_id'];

$sql = "INSERT INTO post(title,description,category,post_date,author,post_img)
        VALUES('{$title}','{$description}',{$category},'{$date}',{$author},'{$file_name}');";
$sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

if (mysqli_multi_query($conn, $sql)) {
    header("Location: http://localhost/news-blog/admin/post.php");
} else {
    echo "<div class='alert alert-danger'>Query Failed</div>";
}
