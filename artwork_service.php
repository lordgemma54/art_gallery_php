<?php
session_start();
// if (!isset($_SESSION["artist_id"])) {
//     exit("Not signed in");
// }

$action = isset($_GET['action']) ? ($_GET['action']) : $_POST['action'];

//handles only data retrival and xml / json processing.  
// plays no role in displaying elements in the browser - ie. NO HTML
$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$dbUser = 'root';
$dbPassword = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$dbUser", "$dbPassword");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

switch ($action) {
    case 'get_gallery':
        generate_gallery_handler($db);
        break;

    case 'get_likes':
        get_likes($db);
        break;

    case 'add_like':
        add_like($db);
        break;

    case 'get_comments':
        get_comments($db);
        break;

    case 'add_comment':
        add_comment($db);
        break;

    case 'get_related_imgs':
        get_related_imgs($db);
        break;

    case 'get_image':
        get_image($db);
        break;

    case 'get_artist_gallery':
        get_artist_gallery($db);
        break;

    case 'delete_artwork':
        delete_artwork($db);
        break;
}

function generate_gallery_handler($db)
{
    // a PDO statement object behaves like a pointer to a db 'cursor' that moves forward through rows it doesnt store the full dataset in memory until you convert it to a php array. They are read-only
    $stmt = $db->query("SELECT id, img_path FROM artwork");
    $artworks = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    shuffle($artworks);
    header("Content-type: text/xml");
    echo generate_xml_all($artworks);

    //maybe switch to json for the main gallery since its the most resource intensive
    // header("Content-type: application/json");
    // echo json_encode($artworks);
}


function generate_xml_all($artworks)
{
    $xmldom = new DOMDocument();
    $images = $xmldom->createElement("images");
    $xmldom->appendChild($images);

    for ($i = 0; $i < count($artworks); $i++) {
        $image = $xmldom->createElement("image");
        $id = $xmldom->createElement('id');
        $id_text = $xmldom->createTextNode($artworks[$i]["id"]);
        $path = $xmldom->createElement('path');
        $path_text = $xmldom->createTextNode($artworks[$i]["img_path"]);
        $id->appendChild($id_text);
        $path->appendChild($path_text);
        $image->appendChild($id);
        $image->appendChild($path);
        $images->appendChild($image);
    }


    return $xmldom->saveXML();
}

function get_likes($db)
{
    $artwork_id = isset($_GET['id']) ? ($_GET['id']) : null;
    $stmt = $db->prepare("SELECT COUNT(*) as 'total'
                        FROM likes WHERE artwork_id = ?");
    $stmt->execute([$artwork_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    header("Content-type: application/json");
    echo (json_encode($result));
}

function add_like($db)
{
    $artwork_id = $_POST["artwork_id"] ?? null;
    $artist_id = $_POST["artist_id"] ?? null;

    $stmt = $db->prepare("INSERT INTO likes (artwork_id, artist_id) VALUES (?, ?)");
    $stmt->execute([$artwork_id, $artist_id]);
}

function add_comment($db)
{
    $artist_id = $_POST["artist_id"];
    $artwork_id = $_POST["artwork_id"];
    $comment = $_POST["comment"];

    $stmt = $db->prepare("INSERT INTO comment (artist_id, artwork_id, comment) VALUES (?, ?, ?)");
    $stmt->execute([$artist_id, $artwork_id, $comment]);
}


function get_comments($db)
{
    $artwork_id = $_GET["artwork_id"];

    $stmt = $db->prepare("SELECT c.comment, a.username 
                        FROM comment c
                        JOIN artist a ON c.artist_id = a.id
                        WHERE c.artwork_id = ? 
                        ORDER BY c.created_at DESC");
    $stmt->execute([$artwork_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header("Content-type: application/json");
    echo json_encode($comments);
}



function get_related_imgs($db)
{
    $artist_id = $_GET["artist_id"];
    $current_id = $_GET["current_id"];

    $stmt = $db->prepare("SELECT id, img_path 
                        FROM artwork
                        WHERE artist_id = ? 
                        AND id <> ?
                        ORDER BY RAND()
                        LIMIT 3");
    $stmt->execute([$artist_id, $current_id]);
    $related_imgs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header("Content-type: application/json");
    echo json_encode($related_imgs);
}

function get_image($db)
{

    $artwork_id = $_GET["artwork_id"];
    $stmt = $db->prepare("SELECT aw.*, ar.username, ar.avatar_img_path 
                        FROM artwork aw
                        JOIN artist ar ON aw.artist_id = ar.id
                        WHERE aw.id = ?");
    $stmt->execute([$artwork_id]);
    $artwork = $stmt->fetch(PDO::FETCH_ASSOC);
    header("Content-type: application/json");
    echo json_encode($artwork);
}

function get_artist_gallery($db)
{
    $artist_id = $_GET["artist_id"];
    $stmt = $db->query("SELECT id, img_path FROM artwork WHERE artist_id = ?");
    $stmt->execute([$artist_id]);
    $artist_gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header("Content-type: application/json");
    echo json_encode($artist_gallery);
}

function delete_artwork($db)
{
    $artwork_id = $_POST["artwork_id"];
    $artist_id = $_SESSION["artist_id"];

    $stmt = $db->prepare("DELETE  
                        FROM artwork
                        WHERE id = ?
                        AND artist_id = ?");
    $stmt->execute([$artwork_id, $artist_id]);

    header("Content-type: application/json");
    echo json_encode(["success" => true]);
}

// function get_likes_JSON($result)
// {

//     return json_encode($result);
// }
// header("Content-type: application/json");
// print getLikes_JSON();

// password_hash($password, PASSWORD_DEFAULT);







// $get_row_query = $db->prepare("SELECT 
//                                 aw.*,
//                                 ar.username,
//                                 ar.id,
//                                 ar.avatar_img_path,
//                                 c.comment,
//                                 c.created_at,
//                                 (SELECT COUNT(*) FROM likes WHERE aw.id = artwork_id) AS 'likes'
//                                 FROM artwork aw
//                                 JOIN artist ar ON ar.id = aw.artist_id 
//                                 LEFT JOIN likes l ON l.artwork_id = aw.id
//                                 LEFT JOIN comment c ON c.artwork_id = aw.id
//                                 WHERE aw.id = ?");

// $get_row_query->execute(array($id));

// $artwork = $get_row_query->fetch(PDO::FETCH_ASSOC);
// print_r($artwork);
