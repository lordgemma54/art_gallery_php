<!-- 
Name: Rahul Venkatesh
Final Project 
Course: CPSC 5210 - Web dev 2
Description: This art gallery app allows a user do create their own gallery to show off their artwork.  The 'artist' (user) can upload files of their artwork and like and comment on the art of other artists.  Likes, comments, and clicking on 'related images', a mini gallery of other works by this same artist, refresh the artwork on the page without reload. -->
<?php
session_start();

$artist_id = $_SESSION["artist_id"];
$bio = $_POST["bio"];

$base_path = "images/";

$allowed_img_types = ["image/jpeg", "image/png", "image/jpg"];

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($bio) {
    $stmt1 = $db->prepare("UPDATE artist 
                            SET bio = ?
                            WHERE id = ?");
    $stmt1->execute([$bio, $artist_id]);
}

// process avatars: 
if (!empty($_FILES["avatar"]["name"])) {
    $file_type = $_FILES["avatar"]["type"];

    if (in_array($file_type, $allowed_img_types)) {
        $filename = uniqid() . "_" . $_FILES["avatar"]["name"];
        $upload_path = $base_path . "avatar/" . $filename;
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $upload_path);

        $stmt = $db->prepare("UPDATE artist 
                            SET avatar_img_path = ? 
                            WHERE id = ? ");
        $stmt->execute([$upload_path, $artist_id]);
    }
}


foreach ($_FILES["artworks"]["tmp_name"] as $key => $tmp_name) {
    if (!empty($tmp_name)) {
        $file_type = $_FILES["artworks"]["type"][$key];

        if (in_array($file_type, $allowed_img_types)) {
            $filename = uniqid() . "_" . $_FILES["artworks"]["name"][$key];
            $upload_path = $base_path . "artwork/" . $filename;
            move_uploaded_file($tmp_name, $upload_path);

            $stmt2 = $db->prepare("INSERT INTO artwork (artist_id, img_path) VALUES (?, ?)");
            $stmt2->execute([$artist_id, $upload_path]);
        }
    }
}

header("Location: profile.php?id=" . $artist_id);
exit();
