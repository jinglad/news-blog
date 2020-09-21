<?php

include "config.php";
$post_id = $_POST['post_id'];
if (empty($_FILES['new-image']['name'])) {
    $file_name = $_POST['old-image'];
} else {
    $error = [];
    $file_name = $_FILES["new-image"]["name"];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];
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
// $category = mysqli_real_escape_string($conn, $_POST['category']);

echo $sql = "UPDATE post SET 'title' = '{$title}',description = '{$description}',category = {$category},post_img ='{$file_name}' WHERE post_id = '{$post_id}'";

// if (mysqli_query($conn, $sql)) {
//     header("Location: http://localhost/news-blog/admin/post.php");
// } else {
//     echo "Query Failed";
// }
