<?php
define('DB_SERVER', 'diverville.francecentral.cloudapp.azure.com');
define('DB_USERNAME', 'divervilleApp');
define('DB_PASSWORD', 'd!v#r');
define('DB_NAME', 'divervilleDB');
define('DB_PORT', '3306');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>