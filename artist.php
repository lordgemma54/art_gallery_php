<?php
$username = $_GET["username"];
print $username;

$username = isset($_GET["username"]) ? $_GET["username"] : null;
// print $id . "<br>";

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
