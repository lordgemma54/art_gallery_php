<?php
session_start();
include("top.html");

$artwork_id = isset($_GET["id"]) ? $_GET["id"] : null;
//    $_SESSION isset($_SESSION["logged-in"] && $_SESSION["logged-in"] === true)

print_r($_SESSION);

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';

$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT aw.*, 
                    ar.username AS 'artist name',
                    ar.id AS 'artist id', 
                    ar.avatar_img_path
                    FROM artwork aw
                    JOIN artist ar ON aw.artist_id = ar.id
                    WHERE aw.id = ?");
$stmt->execute(array($artwork_id));
$artwork = $stmt->fetch(PDO::FETCH_ASSOC);




// print_r($artwork);
?>


<div class="page-container">

    <input type="hidden" id="artwork_id" value="<?= $artwork_id ?>">

    <!-- ------------------------------------------------------------- -->
    <input type="hidden" id="login_status" value="<?= isset($_SESSION['logged-in']) && $_SESSION['logged-in'] === true ? '1' : '0' ?>">
    <!-- ------------------------------------------------------------- -->

    <div id="artwork-container">
        <img id="artwork" src="<?= $artwork["img_path"] ?>" alt="artwork <?= $artwork_id ?>">
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


<div class="artist-container">
    <h2>
        <a href="artist.php?username=<?= htmlspecialchars($artwork['username']) ?>"><?= $artwork['username'] ?>
            <img src="<?= $artwork['avatar_img_path'] ?>" alt="artist profile">
        </a>
    </h2>
    <img src="<?= $artwork["avatar_img_path"] ?>" alt="">


    <div id="related-works"> </div>
</div>
<!-- 

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