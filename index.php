<?php 
  
$db = //make db connection.
//since no user input is being passed in, no prepared statement required
$img_ids_all = rand($db->query("SELECT id FROM artwork;"));


function generate_xml($img_ids_all) {
    $xmldom = new DOMDocument();

    $image = $xmldom->createElement("image"); 
    $xmldom->appendChild($image);

    
    for($i = 0; $i < $img_ids_all; $i++) {
        $image_id = $xmldom->createElement("image-id");
        $image_id_num = $xmldom->createTextNode($img_ids_all[$i]);
        $image_id->appendChild($image_id_num);
        
        $image->appendChild($image_id);
    }

    header("Content-type: text/xml");
    return $xmldom->saveXML();

}



?>