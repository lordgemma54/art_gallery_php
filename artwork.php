<?php
session_start();
include("top.html");
include("navigation-bar.php");

$artwork_id = isset($_GET["id"]) ? $_GET["id"] : null;
//    $_SESSION isset($_SESSION["logged-in"] && $_SESSION["logged-in"] === true)

// print_r($_SESSION);

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT aw.*, 
                    ar.username AS 'username',
                    ar.id AS 'artist_id', 
                    ar.avatar_img_path
                    FROM artwork aw
                    JOIN artist ar ON aw.artist_id = ar.id
                    WHERE aw.id = ?");
$stmt->execute(array($artwork_id));
$artwork = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($artwork);
?>
<input type="hidden" id="artwork_id" value="<?= $artwork_id ?>">
<input type="hidden" id="artist_id" value="<?= $artwork["artist_id"] ?>">
<input type="hidden" id="current_artist_username" value="<?= $username ?>">
<!-- ------------------------------------------------------------- -->
<input type="hidden" id="login_status" value="<?= isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true ? '1' : '0' ?>">
<!-- ------------------------------------------------------------- -->


<div id="artwork-container">
    <img id="artwork-img" src="<?= $artwork["img_path"] ?>" alt="artwork: <?= $artwork_id ?>">
    <p id="title"><?= htmlspecialchars($artwork["title"]) ?></p>
</div>
<!-- ------------------------------------------------------------- -->

<div class="likes-container">
    <h2>likes</h2>
    <button type="button" id="like-btn">🔥 Like </button>
    <span id="like-count"></span>
</div>

<div class="comments-container">
    <h2>comments</h2>
    <form action="">
        <input type="text" name="comment" id="comment_input"> Add a comment
        <button type="button" id="comment-btn">Submit</button>
    </form>
    <div id="comments-list"></div>
</div>

<!-- ------------------------------------------------------------- -->

<div class="artist-container">
    <a id="artist-link" href="profile.php?id=<?= $artwork["artist_id"] ?>">
        <?= htmlspecialchars($artwork['username']) ?>
        <img id="artist-avatar" src="<?= $artwork['avatar_img_path'] ?>" alt="artist profile">
    </a>
    <div id="related-works"></div><br>
    <p id="related_text">Other works by this artist</p>
</div>


<script src="artwork.js" type="text/javascript"></script>
<?php include("bottom.html"); ?>