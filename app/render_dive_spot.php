<?php
require_once '../app/twig.php';

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    echo $twig->render('dive_spot.html', ['id' => $id, 'spot_name' => $name, 'depth' => $depth, 'type' => $type, 'lat' => $posLat, 'lng' => $posLng,
    'image_names' => $spot_image_names,
    'error_message' => $msg , 'style' => $style, 
    'user' => $_SESSION['username']]);
} else{
    echo $twig->render('dive_spot.html', ['id' => $id, 'spot_name' => $name, 'depth' => $depth, 'type' => $type, 'lat' => $posLat, 'lng' => $posLng,
    'image_names' => $spot_image_names,
    'error_message' => $msg , 'style' => $style]);
}

?>