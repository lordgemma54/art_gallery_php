<?php include("top.html"); ?>
<?php
    $id = isset($_GET["id"]) ? $_GET["id"] : null;
    // print $id . "<br>";

    $host = 'localhost';
    $port = '3306';
    $database = 'art_gallery';
    $user = 'root';
    $password = 'Mr.PouncyChonkers@400';

    $db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$user", "$password");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $get_row_query = $db->prepare("SELECT 
                                aw.*,
                                ar.username,
                                ar.avatar_img_path,
                                c.comment,
                                c.created_at,
                                (SELECT COUNT(*) FROM likes WHERE aw.id = artwork_id) AS 'likes'
                                FROM artwork aw
                                JOIN artist ar ON ar.id = aw.artist_id 
                                LEFT JOIN likes l ON l.artwork_id = aw.id
                                LEFT JOIN comment c ON c.artwork_id = aw.id
                                WHERE aw.id = ?");
                $get_row_query->execute(array($id));

    $artwork = $get_row_query->fetch(PDO::FETCH_ASSOC);
    print_r($artwork);

?>
    <div class= "artwork-container">
        <div class="artwork">
            <img src="<?= $artwork["img_path"] ?>" alt="artwork <?= $artwork["id"] ?>">
            <p class="title"><?= $artwork["title"] ?></p>
        </div>
        <div class="likes">
            <h2>likes</h2>
            <p><?= $artwork["likes"] ?></p>
        </div>

        <div class="comments">
            <h2>comments</h2>
            <p><?= $artwork["comment"] ?></p>
        </div>

        <div class="artist">
            <h2>
                <a href="artist.php?username=<?= htmlspecialchars($artwork['username']) ?>"><?= $artwork['username'] ?></a>
            </h2>
            <img src="<?= $artwork["avatar_img_path"] ?>" alt="">
        </div>


    </div>



<?php include("bottom.html"); ?>
