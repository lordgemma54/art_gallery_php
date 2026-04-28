<?php
session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: index.php");
    exit();
}

include("top.html");
include("navigation-bar.php");


$artist_id = $_SESSION["artist_id"];

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT username, bio, avatar_img_path 
                    FROM artist
                    WHERE id = ?");
$stmt->execute([$artist_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT id, img_path 
                    FROM artwork
                    WHERE artist_id = ?");
$stmt->execute([$artist_id]);
$gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Edit profile</h2>
<form action="process-profile.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="artist_id" value="<?= $artist_id ?>">
    <input type="hidden" name="login_status" value="<?= isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true ? '1' : '0' ?>">

    <p id="bio-label"><label>Bio</label></p>
    <textarea name="bio" rows="5" cols="40"><?php echo htmlspecialchars($profile['bio']); ?> </textarea> <br>
    <div id="profile-inputs">
        <?php if (!empty($profile["avatar_img_path"])) { ?>
            <img src="<?= $profile["avatar_img_path"] ?>" alt="avatar image" width="120">
        <?php } ?> <br>

        <label>Replace Avatar</label>
        <input type="file" name="avatar">
    </div>

    <label>Add More Artwork</label>
    <input type="file" name="artworks[]" multiple>

    <div class="artist-gallery">

        <?php foreach ($gallery as $img) { ?>

            <div class="tile" id="tile-<?= $img["id"] ?>">
                <img class="gallery-tile" src="<?= $img["img_path"] ?>" alt="image: <?= $img["id"] ?>">
                <button type="button" class="delete-btn" data-id="<?= $img["id"] ?>">Delete</button>
            </div>
        <?php } ?>
    </div>

    <div id="save-changes-btn"><button type="submit">Save changes</button></div>

</form>
<script src="edit-profile.js" type="text/javascript"></script>
<?php include("bottom.html") ?>