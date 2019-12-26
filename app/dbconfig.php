<?php
define('DB_SERVER', '40.89.160.248');
define('DB_USERNAME', 'divervilleApp');
define('DB_PASSWORD', 'diver');
define('DB_NAME', 'divervilleDB');
define('DB_PORT', '3306');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>