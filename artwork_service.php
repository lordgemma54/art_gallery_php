<?php

$action = $_GET['action'];
//handles only data retrival and xml / json processing.  
// plays no role in displaying elements in the browser - ie. NO HTML
$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$user = 'root';
$password = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$user", "$password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

switch ($action) {
    case 'get_gallery':
        generate_gallery_handler($db);
        break;
}

function generate_gallery_handler($db)
{
    // a PDO statement object behaves like a pointer to a db 'cursor' that moves forward through rows
    // it doesnt store the full dataset in memory until you convert it to a php array. They are read-only
    $img_ids_all = $db->query("SELECT id, img_path FROM artwork");
    //already returns an array - dont add square brackets to $artworks, that creates a nested array
    $artworks = $img_ids_all ? $img_ids_all->fetchAll(PDO::FETCH_ASSOC) : [];
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


// function getLikes_JSON($db)
// {
//     $artwork_id = $_POST["artwork_id"];

//     $post_likes = $db->prepare("INSERT INTO likes WHERE artwork_id = ? ");
//     $post_likes->execute(array($artwork_id));

//     $get_likes = $db->prepare("SELECT COUNT(*) as 'total'
//                         FROM likes WHERE artwork_id = ?");

//     $get_likes = $db->exectue(array($artwork_id));
//     $artwork_likes = $get_likes(PDO::FETCH_ASSOC);

//     return json_encode($artwork_likes);
// }
// header("Content-type: application/json");
// print getLikes_JSON();

// password_hash($password, PASSWORD_DEFAULT);
