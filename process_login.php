<!-- 
Name: Rahul Venkatesh
Final Project 
Course: CPSC 5210 - Web dev 2
Description: This art gallery app allows a user do create their own gallery to show off their artwork.  The 'artist' (user) can upload files of their artwork and like and comment on the art of other artists.  Likes, comments, and clicking on 'related images', a mini gallery of other works by this same artist, refresh the artwork on the page without reload. -->
<?php
session_start();

$un = $_POST["username"];
$pw = $_POST["password"];
$redirect_id = $_POST["redirect_to"];
// $login_successful = false;

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT id, username FROM artist WHERE artist.username = ?");
$stmt->execute(["$un"]);
$artist = $stmt->fetch(PDO::FETCH_ASSOC);

if ($artist) {
    // use password_verify() here
    $stmt = $db->prepare("SELECT password FROM artist WHERE artist.username = ?");
    $stmt->execute([$artist['username']]);
    $artist_pw = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($pw, $artist_pw["password"])) {
        $_SESSION["artist_id"] = $artist['id'];
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $artist["username"];
        if (!empty($redirect_id)) {
            header("Location: artwork.php?id=" . $redirect_id);
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
