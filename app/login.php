<?php 
require_once '../app/twig.php';

echo $twig->render('login.html', ['error_message' => "" , 'style' => "visibility: hidden;"]); 

?>