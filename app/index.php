<?php 
session_name('mysession'); 
session_start();
require_once '../app/twig.php';
require_once '../app/random_spots_index.php';
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ($_SESSION["usertype"] === "diver"){
        //header("location: welcome.php");
        require_once '../app/render_diver_main.php';
        exit;
    }else{
        require_once '../app/render_divecenter_main.php';
        exit;
    }
}

echo $twig->render('index.html', ['home' => "nav-item active", 
'services' => "nav-item", 
'contactus' => "nav-item", 
'aboutus' => "nav-item",
'login' => "nav-item",
'name1' => $name1, 'name2' => $name2, 'name3' => $name3,
'depth1' => $depth1, 'depth2' => $depth2, 'depth3' => $depth3,
'type1' => $type1, 'type2' => $type2, 'type3' => $type3,
'id1' => $id1, 'id2' => $id2, 'id3'=> $id3,
'img1' => $img1, 'img2' => $img2, 'img3' => $img3]); 
?>