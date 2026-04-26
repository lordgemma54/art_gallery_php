<?php
session_start();

if (!isset($_SESSION["logged-in"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];
