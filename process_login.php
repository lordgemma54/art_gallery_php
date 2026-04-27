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
        if (!empty($redirect_id)) {
            header("Location: artwork.php?id=" . $redirect_id);
        } else {
            header("Location: index.php");
        }
        exit();
    }
}
