<?php
require_once '../app/twig.php';

if(isset($_SESSION["loggedin"])  && $_SESSION["loggedin"] === true){
    echo $twig->render('dive_event.html', ['id' => $id, 'event_name' => $name,'date' => $date, 'maxdivers' => $maxdivers, 'diveCenterName' => $diveCenterName, 'spotName' => $spotName, 'depth' => $depth,
    'type' => $type,'participants' => $participants, 'divers' => $divers,
    'error_message' => $msg , 'style' => $style, 
    'user' => $_SESSION['username']]);
} else{
    echo $twig->render('dive_event.html', ['id' => $id, 'event_name' => $name,'date' => $date, 'maxdivers' => $maxdivers, 'diveCenterName' => $diveCenterName, 'spotName' => $spotName, 'depth' => $depth,
    'type' => $type,'participants' => $participants,'divers' => $divers,
    'error_message' => $msg , 'style' => $style]);
}

?>