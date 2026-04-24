<?php 
    $username = $_GET["username"];
    print $username;

    $username = isset($_GET["username"]) ? $_GET["username"] : null;
    // print $id . "<br>";

    $host = 'localhost';
    $port = '3306';
    $database = 'art_gallery';
    $user = 'root';
    $password = 'Mr.PouncyChonkers@400';

    $db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$user", "$password");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>