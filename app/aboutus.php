<?php 
require_once '../app/twig.php';
echo $twig->render('aboutus.html', ['home' => "nav-item", 
'services' => "nav-item", 
'contactus' => "nav-item", 
'aboutus' => "nav-item active",
'login' => "nav-item"]); 
?>