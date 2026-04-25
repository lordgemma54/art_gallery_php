<?php include("top.html"); ?>

<?php
$artwork_id = isset($_GET["id"]) ? $_GET["id"] : null;

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$user = 'root';
$password = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$user", "$password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT * FROM artwork WHERE artwork.id = ?");
$stmt->execute(array($artwork_id));
$artwork = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($artwork);
?>


<div class="artwork-container">
    <input type="hidden" id="artwork_id" value="<?= $artwork_id ?>">


    <div class="artwork">
        <img src="<?= $artwork["img_path"] ?>" alt="artwork <?= $artwork_id ?>">
        <p class="title"><?= $artwork["title"] ?></p>
    </div>
</div>

<div class="likes-container">
    <h2>likes</h2>
    <span id="like-count"></span>
    <button id="like-btn">🔥 Like </button>
    <!-- <p><?= $artwork["likes"] ?></p> -->
</div>

<div class="comments-container">
    <h2>comments</h2>
    <!-- <p><?= $artwork["comment"] ?></p> -->
</div>

<!-- <div class="artist-container">
    <h2>
        <a href="artist.php?username=<?= htmlspecialchars($artwork['username']) ?>"><?= $artwork['username'] ?>
            <img src="<?= $artwork['avatar_img_path'] ?>" alt="artist profile">
        </a>
    </h2>
    <img src="<?= $artwork["avatar_img_path"] ?>" alt="">


    <div id="other-works">

    </div> -->
<!-- <div class="likes-container">

    </div> -->
<!-- <form action="artwork_service.php" method="post">
        <button type="submit" name="action" value="get_likes">Like</button>
        <input type="hidden" name="artwork_id" value=>
    </form> -->

<!-- </div> -->


<!-- <form action="comment-submission.php" method="post">
    <textarea name="comment" id="user-comment"></textarea> <br>
    <button type="submit" name="action" value="get-comment">Comment</button>
</form> -->



<script src="artwork.js" type="text/javascript"></script>
<?php include("bottom.html"); ?>