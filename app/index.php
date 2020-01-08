<?php 
require_once '../app/twig.php';
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ($_SESSION["usertype"] === "diver"){
        //header("location: welcome.php");
        echo $twig->render('welcomediver.html', ['name' => $_SESSION["username"], 'home' => "nav-item active", 
        'services' => "nav-item", 
        'contactus' => "nav-item", 
        'aboutus' => "nav-item",
        'login' => "nav-item"] ); 
        exit;
    }else{
        echo $twig->render('welcomedivecenter.html', ['name' => $_SESSION["username"], 'home' => "nav-item active", 
        'services' => "nav-item", 
        'contactus' => "nav-item", 
        'aboutus' => "nav-item",
        'login' => "nav-item" ]); 
        exit;
    }
}

echo $twig->render('index.html', ['home' => "nav-item active", 
'services' => "nav-item", 
'contactus' => "nav-item", 
'aboutus' => "nav-item",
'login' => "nav-item"]); 
?>