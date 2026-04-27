<?php
session_start();
// session_destroy();
// header("Location: login.php");
// exit();

if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}

print_r($_SESSION);
include("top.html");

$artist_id = $_SESSION["artist_id"];

?>
<form action="process-profile.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="artist_id" value=<?= $artist_id ?>>

    <div class="artist-details">
        <textarea name="bio" placeholder="enter optional details about yourself"></textarea>

        <label>Upload a profile image:</label>
        <input type="file" name="avatar">

        <label>Upload artwork</label>
        <input type="file" name="artworks[]" multiple>

        <button type="submit">Create Profile</button>
    </div>
</form>

<?php include("bottom.html"); ?>