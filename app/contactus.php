<?php 
require_once '../app/twig.php';
echo $twig->render('contactus.html', ['home' => "nav-item", 
'services' => "nav-item", 
'contactus' => "nav-item active", 
'aboutus' => "nav-item",
'login' => "nav-item"]); 
?>