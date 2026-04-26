<?php
session_start();
$un = $_POST["username"];
$pw = $_POST["password"];

// $hashed_password = password_hash($password, PASSWORD_DEFAULT);

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$user = 'root';
$password = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$user", "$password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// check for duplicate usernames
$check_user = $db->prepare("SELECT username FROM artist WHERE username = ?");
$check_user->execute([$un]);
$user = $check_user->fetch(PDO::FETCH_ASSOC);
if ($user) {
    $stmt = $db->prepare("INSERT INTO artist (username, password) VALUES (? , ?)");
    $stmt->execute([$un, $pw]);
    header("Location: login.php");
}
