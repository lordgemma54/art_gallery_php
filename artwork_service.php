<?php 

//handles only data retrival and xml / json processing.  
// plays no role in displaying elements in the browser - ie. NO HTML
$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$user = 'root';
$password = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$user", "$password");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// a PDO statement object behaves like a pointer to a db 'cursor' that moves forward through rows
// it doesnt store the full dataset in memory until you convert it to a php array. They are read-only

$img_ids_all = $db->query("SELECT id, img_path FROM artwork");

//already returns an array
$artworks = $img_ids_all ? $img_ids_all->fetchAll(PDO::FETCH_ASSOC) : [];
shuffle($artworks);

//the arrow function has to be inside an array 
// foreach($img_ids_all as $row) {
//     $artworks[] =[
//      'id' => $row['id'],
//      'img_path' => $row['img_path'] ];
//     }
    

echo generate_xml($artworks);

function generate_xml($artworks) {
    $xmldom = new DOMDocument();
    $images = $xmldom->createElement("images"); 
    $xmldom->appendChild($images);
    
    for($i = 0; $i < count($artworks); $i++) {
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
     
    header("Content-type: text/xml");
    return $xmldom->saveXML();

}

// password_hash($password, PASSWORD_DEFAULT);
?>
