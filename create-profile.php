<!-- 
Name: Rahul Venkatesh
Final Project 
Course: CPSC 5210 - Web dev 2
Description: This art gallery app allows a user do create their own gallery to show off their artwork.  The 'artist' (user) can upload files of their artwork and like and comment on the art of other artists.  Likes, comments, and clicking on 'related images', a mini gallery of other works by this same artist, refresh the artwork on the page without reload. -->
<?php
session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';

include("top.html");

$artist_id = $_SESSION["artist_id"];

?>
<form action="process-profile.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="artist_id" value="<?= $artist_id ?>">

    <div class="artist-details">
        <textarea name="bio" placeholder="enter optional details about yourself"></textarea>

        <p class="create-profile-text"><label>Upload a profile image:</label></p>
        <input type="file" name="avatar">

        <p class="create-profile-text"><label>Upload artwork</label></p>
        <input type="file" name="artworks[]" multiple>

        <button type="submit">Create Profile</button>
    </div>
</form>

<?php include("bottom.html"); ?>