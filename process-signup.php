<!-- 
Name: Rahul Venkatesh
Final Project 
Course: CPSC 5210 - Web dev 2
Description: This art gallery app allows a user do create their own gallery to show off their artwork.  The 'artist' (user) can upload files of their artwork and like and comment on the art of other artists.  Likes, comments, and clicking on 'related images', a mini gallery of other works by this same artist, refresh the artwork on the page without reload. -->
<?php
session_start();
$un = $_POST["username"];
$pw = $_POST["password"];
$email = $_POST["email"];

$hashed_password = password_hash($pw, PASSWORD_DEFAULT);

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// check for duplicate usernames
$check_user = $db->prepare("SELECT username FROM artist WHERE username = ?");
$check_user->execute([$un]);
$existingUser = $check_user->fetch(PDO::FETCH_ASSOC);
if ($existingUser) {
    header("Location: signup.php");
    exit();
} else {
    $stmt = $db->prepare("INSERT INTO artist (username, password, email) VALUES (? , ?, ?)");
    $stmt->execute([$un, $hashed_password, $email]);
    $_SESSION["logged_in"] = true;
    $_SESSION["artist_id"] = $db->lastInsertId();
    $_SESSION["username"] = $un;
    header("Location: create-profile.php");
    exit();
}
