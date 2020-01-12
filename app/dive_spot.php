<?php
$spotName  = $_GET['name'];

session_name('mysession');  
session_start();

// Include config file
require_once "../app/dbconfig.php";
require_once "../app/twig.php";
 
// Prepare a select statement
$sql = "SELECT id, name, depth, type, posLat, posLng FROM divespots  WHERE name = ?;";
        
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_name);
    
    // Set parameters
    $param_name = $spotName;
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);
        
        // Check if dive spot exists
        if(mysqli_stmt_num_rows($stmt) == 1){                    
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id, $name, $depth, $type, $posLat, $posLng);
            if(mysqli_stmt_fetch($stmt)){
                //printf ("%s (%s)\n", $username, $hashed_password);
                //echo ("Fetch");
                $msg = "";
                $style = "visibility: hidden;";
                require '../app/render_dive_spot.php';
            } else {
                echo "Something went wrong with the variables of spot.";
            }
        } else{
            // Display an error message if username doesn't exist
            $spot_err = "No dive spot found with that username.";
            echo $twig->render('login.html', ['error_message' => $username_err, 'style' => "visibility: visible;"]);
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
?>