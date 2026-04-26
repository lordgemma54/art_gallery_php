<?php
session_start();

$user_id = $_POST["user_id"];
$bio = $_POST["bio"];

$base_path = "images/artwork/";

$allowed_img_types = ["image/jpeg", "image/png", "image/jpg"];

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// process avatars: 
if (!empty($_FILES["avatar"]["name"])) {
    $file_type = $_FILES["avatar"]["type"];

    if (in_array($file_type, $allowed_img_types)) {
        $filename = uniqid() . "_" . $_FILES["avatar"]["name"];
        $upload_path = $base_path . $filename;
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $upload_path);

        $stmt = $db->prepare("UPDATE artist SET avatar_img_path = ?, bio = ?, WHERE id = ? ");
        $stmt->execute([$upload_path, $bio, $user_id]);
    }
}
