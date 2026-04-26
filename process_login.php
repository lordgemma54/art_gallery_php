<?php
session_start();

$un = $_POST["username"];
$pw = $_POST["password"];
$redirect_id = $_POST["redirect_to"];
$login_successful = false;

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$user = 'root';
$password = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$user", "$password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT id, username FROM artist WHERE artist.username = ?");
$stmt->execute(["$un"]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // use password_verify() here
    $stmt = $db->prepare("SELECT password FROM artist WHERE artist.username = ?");
    $stmt->execute([$user['username']]);
    $user_pw = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pw === $user_pw["password"]) {
        $login_successful = true;
    }
}

// ----------------------------------------------------
if ($login_successful) {
    $_SESSION["username"] = $user['username'];
    $_SESSION["logged-in"] = true;
    if (!empty($redirect_id)) {
        header("Location: artwork.php?id=" . $redirect_id);
    } else {
        header("Location: index.php");
    }
    exit();
}
