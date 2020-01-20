<?php
require_once '../app/twig.php';


if (isset($_SESSION["loggedin"])  && $_SESSION["loggedin"] === true){
    echo $twig->render('user_account.html', ['account_details' => $account_details,
    'error_message' => $msg , 'style' => $style, 
    'user' => $_SESSION['username']]);
} else{
    echo $twig->render('user_account.html', ['account_details' => $account_details,   
    'error_message' => $msg , 'style' => $style]);
}

?>