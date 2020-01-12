<?php
require_once '../app/twig.php';
echo $twig->render('welcomediver.html', ['user' => $_SESSION["username"], 'home' => "nav-item active", 
'services' => "nav-item", 
'contactus' => "nav-item", 
'aboutus' => "nav-item",
'login' => "nav-item",
'name1' => $name1, 'name2' => $name2, 'name3' => $name3,
'depth1' => $depth1, 'depth2' => $depth2, 'depth3' => $depth3,
'type1' => $type1, 'type2' => $type2, 'type3' => $type3,
'id1' => $id1, 'id2' => $id2, 'id3'=> $id3]);
?>