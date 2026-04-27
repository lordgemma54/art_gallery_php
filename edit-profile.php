<?php
session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: index.php");
    exit();
}

include("top.html");
include("navigation-bar.php");

// print_r($_SESSION);

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
                    WHERE artist.id = ?");
$stmt->execute([$artist_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT id, img_path 
                    FROM artwork
                    WHERE artist.id = ?");
$stmt->execute([$artist_id]);
$gallery->fetch(PDO::FETCH_ASSOC);
?>

<h2>Edit profile</h2>
<form action="process-profile.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="artist_id" value="<?= $artist_id ?>">;
    <label>Bio</label>
    <textarea name="bio" rows="5" cols="40"><?php echo htmlspecialchars($profile['comment']); ?> </textarea> <br>

    <?php if (!empty($profile["avatar_img_path"])) { ?>
        <img src="<?= $profile["avatar_img_path"] ?>" alt="avatar image" width="120">
    <?php } ?>

    <label>Replace Avatar</label>
    <input type="file" name="avatar">

    <label>Add More Artwork</label>
    <input type="file" name="artworks[]" multiple>

    <div class="artist-gallery">
        <?php foreach ($gallery as $img) { ?>
            <img class="gallery-tile" src="<?= $img["img_path"] ?>" alt="image: <?= $img["id"] ?>">
            <a href="artwork_service.php">Delete
            </a>

        <?php } ?>
    </div>

    <button type="submit">Save changes</button>

</form>

<?php include("bottom.html") ?>