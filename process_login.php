<?php
session_start();

$un = $_POST["username"];
$pw = $_POST["password"];
$redirect_id = $_GET["redirect-to"];

$stmt - $db->prepare("SELECT username FROM artist WHERE artist.username = ?");
$stmt->execute(["$un"]);
$username = $stmt->fetch(PDO::FETCH_ASSOC);

if ($username) {
    // use password_verify() here
}

// ----------------------------------------------------
if ($login_successful) {
    $_SESSION["logged-in"] = true;
    if (!empty($redirect_id)) {
        header("Location: artwork.php?id=" . $redirect_id);
    } else {
        header("Location: index.php");
    }
    exit();
}
