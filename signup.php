<!-- 
Name: Rahul Venkatesh
Final Project 
Course: CPSC 5210 - Web dev 2
Description: This art gallery app allows a user do create their own gallery to show off their artwork.  The 'artist' (user) can upload files of their artwork and like and comment on the art of other artists.  Likes, comments, and clicking on 'related images', a mini gallery of other works by this same artist, refresh the artwork on the page without reload. -->
<?php
include("top.html");
?>

<div class="container">
    <div class="card">
        <form class="signup-form" action="process-signup.php" method="post">
            <label><strong>Username</strong> <input type="text" name="username" size="16" required></label> <br>
            <label><strong>Password</strong> <input type="password" name="password" size="16" required></label> <br>
            <label><strong>Email</strong> <input type="email" name="email" size="16" required></label> <br>
            <div class="form-actions">
                <input class="button button-primary action-btn" type="submit" value="Sign up">
            </div>
        </form>
        <div class="links"><a href="login.php">Back to login</a></div>
    </div>
</div>

<?php
include("bottom.html");
?>