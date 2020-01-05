<?php 
require_once '../app/twig.php';
echo $twig->render('services.html', ['home' => "nav-item", 
'services' => "nav-item active", 
'contactus' => "nav-item", 
'aboutus' => "nav-item",
'login' => "nav-item"]); 
?>