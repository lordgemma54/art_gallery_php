<?php
session_start();
// session_destroy();
// header("Location: login.php");
// exit();

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