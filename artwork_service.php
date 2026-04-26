<?php
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
        generate_likes_handler($db);
        break;

    case 'add_like':
        add_like($db);
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

function generate_likes_handler($db)
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
    $artwork_id = isset($_POST["artwork_id"]) ? $_POST["artwork_id"] : null;
    $post_likes = $db->prepare("INSERT INTO likes WHERE artwork_id = ? ");
    $post_likes->execute([$artwork_id]);
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
