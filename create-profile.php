<?php
session_start();
if (!isset($_SESSION["logged-in"])) {
    header("Location: login.php");
    exit();

    include("top.html");
}
$user_id = $_SESSION["user_id"];
?>
<form action="process-profile.php" method="post" enctype="multipart/form-data">

    <div class="artist-details">
        <textarea name="bio" id="bio-area" placeholder="enter optional details about yourself"></textarea>
        <div class="total-likes">Total likes:
            <span class="like-counter"></span>
        </div>
        <div class="total-comments">Total comments:
            <span class="comment-counter"></span>
        </div>
        <label>Upload a profile image:</label>
        <input type="file" name="avatar">

        <label>Upload artwork</label>
        <input type="file" name="artworks[]" multiple>
        <button type="submit">Create Profile</button>
    </div>
</form>