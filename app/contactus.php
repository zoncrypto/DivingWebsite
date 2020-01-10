<?php
session_name('mysession');  
session_start();
require_once '../app/twig.php';
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        //header("location: welcome.php");
        echo $twig->render('contactus.html', ['name' => $_SESSION["username"], 'home' => "nav-item", 
        'services' => "nav-item", 
        'contactus' => "nav-item active", 
        'aboutus' => "nav-item",
        'login' => "nav-item"] ); 
        exit;
}
echo $twig->render('contactus.html', ['home' => "nav-item", 
'services' => "nav-item", 
'contactus' => "nav-item active", 
'aboutus' => "nav-item",
'login' => "nav-item"]); 
?>