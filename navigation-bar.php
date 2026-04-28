<!-- 
Name: Rahul Venkatesh
Final Project 
Course: CPSC 5210 - Web dev 2
Description: This art gallery app allows a user do create their own gallery to show off their artwork.  The 'artist' (user) can upload files of their artwork and like and comment on the art of other artists.  Likes, comments, and clicking on 'related images', a mini gallery of other works by this same artist, refresh the artwork on the page without reload. -->
<?php
if (session_status() === PHP_SESSION_NONE) {
      session_start();
}
$artist_id = $_SESSION["artist_id"] ?? null;

?>
<nav class="navbar">
      <a href="index.php">Home</a>

      <?php if ($artist_id) { ?>
            <a href="profile.php?id=<?= $artist_id ?>">Profile</a>
            <a href="logout.php">Logout</a>

      <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
      <?php } ?>

</nav>