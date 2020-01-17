<?php
require_once '../app/twig.php';


if (isset($_SESSION["loggedin"])  && $_SESSION["loggedin"] === true && isset($diver_id)){
    echo $twig->render('dive_event.html', ['id' => $id, 'event_name' => $name,'date' => $date, 'maxdivers' => $maxdivers, 'diveCenterName' => $diveCenterName, 'spotName' => $spotName, 'depth' => $depth,
    'type' => $type,'participants' => $participants, 'divers' => $divers,
    'error_message' => $msg , 'style' => $style, 
    'user' => $_SESSION['username'], 'diver_id' => $diver_id]);
} elseif (isset($_SESSION["loggedin"])  && $_SESSION["loggedin"] === true && isset($center)){
    echo $twig->render('dive_event.html', ['id' => $id, 'event_name' => $name,'date' => $date, 'maxdivers' => $maxdivers, 'diveCenterName' => $diveCenterName, 'spotName' => $spotName, 'depth' => $depth,
    'type' => $type,'participants' => $participants, 'divers' => $divers,
    'error_message' => $msg , 'style' => $style, 
    'user' => $_SESSION['username'], 'center' => $center]);
} else{
    echo $twig->render('dive_event.html', ['id' => $id, 'event_name' => $name,'date' => $date, 'maxdivers' => $maxdivers, 'diveCenterName' => $diveCenterName, 'spotName' => $spotName, 'depth' => $depth,
    'type' => $type,'participants' => $participants,'divers' => $divers,
    'error_message' => $msg , 'style' => $style]);
}

?>