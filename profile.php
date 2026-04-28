<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
include("top.html");
include("navigation-bar.php");

$artist_id = $_GET["id"];

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
$stmt->execute([$artist_id]);
$artist = $stmt->fetch(PDO::FETCH_ASSOC);

// gallery
$stmt = $db->prepare("SELECT id, img_path
                    FROM artwork
                    WHERE artist_id = ?");
$stmt->execute([$artist_id]);
$gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);

//total likes
$stmt = $db->prepare("SELECT COUNT(*) AS 'total_likes' 
                    FROM likes 
                    WHERE artist_id = ?");
$stmt->execute([$artist_id]);
$total_likes = $stmt->fetch(PDO::FETCH_ASSOC);

//total comments
$stmt = $db->prepare("SELECT COUNT(*) AS 'total_comments'
                    FROM comment
                    WHERE artist_id = ?");
$stmt->execute([$artist_id]);
$total_comments = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="profile-page">
    <h1><?= htmlspecialchars($artist["username"]) ?></h1>
    <img src="<?= $artist["avatar_img_path"] !== null ? $artist["avatar_img_path"] : 'images/avatar/default.jpg' ?>" alt="artists avatar">
    <p><?= (htmlspecialchars($artist["bio"])) ?></p>
    <p id="likes-counter">Total likes <span id="total-likes"><?= $total_likes["total_likes"] ?></span></p>
    <p id="comments-counter">Total comments <span id="total-comments"> <?= $total_comments["total_comments"] ?></span></p>

    <?php if (isset($_SESSION["artist_id"]) && $_SESSION["artist_id"] == $artist_id) { ?>
        <a href="edit-profile.php">
            <button id="edit-profile-btn" type="button"> Edit profile</button>
        </a>
    <?php } ?>


    <div class="artist-gallery">
        <?php foreach ($gallery as $img) { ?>
            <a href="artwork.php?id=<?= $img["id"] ?>">
                <img class="gallery-tile" src="<?= $img["img_path"] ?>" alt="image: <?= $img["id"] ?>">
            </a>

        <?php } ?>
    </div>
</div>

<?php include("bottom.html"); ?>