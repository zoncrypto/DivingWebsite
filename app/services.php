<?php
session_name('mysession'); 
session_start(); 
require_once '../app/twig.php';

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        //header("location: welcome.php");

        echo $twig->render('services.html', ['name' => $_SESSION["username"], 'home' => "nav-item", 
        'services' => "nav-item active", 
        'contactus' => "nav-item", 
        'aboutus' => "nav-item",
        'login' => "nav-item"] ); 

        exit;
}
echo $twig->render('services.html', ['home' => "nav-item", 
'services' => "nav-item active", 
'contactus' => "nav-item", 
'aboutus' => "nav-item",
'login' => "nav-item"]); 
?>