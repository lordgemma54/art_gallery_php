<?php
session_start();
include("top.html");

$profile_id = $_GET["id"];

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// artist info
$stmt = $db->prepare("SELECT username, bio, avatar_img_path
                    FROM artist
                    WHERE id = ?");
$stmt->execute([$profile_id]);
$artist = $stmt->fetch(PDO::FETCH_ASSOC);

// gallery
$stmt = $db->prepare("SELECT id, img_path
                    FROM artwork
                    WHERE artist_id = ?");
$stmt->execute([$profile_id]);
$gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="profile-page">
    <h1><?= htmlspecialchars($artist["username"]) ?></h1>
    <img src="<?= $artist["avatar_img_path"] ?>" alt="artists avatar">
    <p><?= htmlspecialchars($artist["bio"]) ?></p>


    <div class="artist-gallery">
        <?php foreach ($gallery as $img) { ?>
            <a href="artwork.php?id=<?= $img["id"] ?>">
                <img class="gallery-tile" src="<?= $img["img_path"] ?>" alt="image number" + <?= $img["id"] ?>>
            </a>

        <?php } ?>
    </div>
</div>

<?php include("bottom.html"); ?>