<?php 
  
$host = 'localhost';
$port = '3306';
$database = 'art_gallery';
$user = 'root';
$password = 'Mr.PouncyChonkers@400';

$db = new PDO("mysql:host=$host;port=$port;dbname=$database", "$user", "$password");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// a PDO statement object behaves like a pointer to a db 'cursor' that moves forward through rows,
// it doesnt store the full dataset in memory until you convert it to a php array. They are read-only

$img_ids_all = $db->query("SELECT id FROM artwork");

$ids = [];
foreach($img_ids_all as $img_id) {
    $ids += $img_id;
    }
    
    shuffle($ids);

    print_r($ids);


echo generate_xml($ids);

function generate_xml($ids) {
    $xmldom = new DOMDocument();
    
    $image = $xmldom->createElement("image"); 
    $xmldom->appendChild($image);
    
    
    for($i = 0; $i < count($ids); $i++) {
        $image_id = $xmldom->createElement("image-id");
        $image_id_num = $xmldom->createTextNode($ids[$i]);
        $image_id->appendChild($image_id_num);
        
        $image->appendChild($image_id);
        }
        
        
    header("Content-type: text/xml");
    return $xmldom->saveXML();

}

// password_hash($password, PASSWORD_DEFAULT);

?>