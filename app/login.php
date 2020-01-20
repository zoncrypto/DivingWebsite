<?php 
require_once '../app/twig.php';

echo $twig->render('login.html', ['error_message' => "" , 'style' => "visibility: hidden;", 'home' => "nav-item", 
'services' => "nav-item", 
'contactus' => "nav-item", 
'aboutus' => "nav-item",
'login' => "nav-item active"]); 

?>