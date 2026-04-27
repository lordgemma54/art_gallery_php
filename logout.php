<!-- 
Name: Rahul Venkatesh
Final Project 
Course: CPSC 5210 - Web dev 2
Description: This art gallery app allows a user do create their own gallery to show off their artwork.  The 'artist' (user) can upload files of their artwork and like and comment on the art of other artists.  Likes, comments, and clicking on 'related images', a mini gallery of other works by this same artist, refresh the artwork on the page without reload. -->
<?php
session_start();
$_SESSION = array();
session_destroy();

header("Location: index.php");
exit();
