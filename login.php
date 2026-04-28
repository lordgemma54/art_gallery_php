<!-- 
Name: Rahul Venkatesh
Final Project 
Course: CPSC 5210 - Web dev 2
Description: This art gallery app allows a user do create their own gallery to show off their artwork.  The 'artist' (user) can upload files of their artwork and like and comment on the art of other artists.  Likes, comments, and clicking on 'related images', a mini gallery of other works by this same artist, refresh the artwork on the page without reload. -->
<?php
include("top.html");
$redirect_id = $_GET["redirect_to"] ?? "";
// $artist_id = $_POST["artist_id"];
?>
<div class="login-container">
    <div>
        <form class="login-form" action="process_login.php" method="post">
            <label><strong>Username</strong><input type="text" name="username" size="16"></label> <br>


            <label><strong>Password</strong><input type="password" name="password" size="16"></label><br>

            <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($redirect_id) ?>">

            <button type="submit"> Login </button>

            <div class="links"><a href="signup.php">Don't have an account? Sign up here</a></div>
        </form>
    </div>
</div>