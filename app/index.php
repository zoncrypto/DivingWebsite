<?php 
require_once '../app/twig.php';
echo $twig->render('index.html', ['home' => "nav-item active", 
'services' => "nav-item", 
'contactus' => "nav-item", 
'aboutus' => "nav-item",
'login' => "nav-item"]); 
?>