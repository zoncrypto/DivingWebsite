<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $spotName = $_POST['name'];
} else {
$spotName  = $_GET['name'];
}

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

                //select all images names for this divespot
                 $sql2 = "SELECT image FROM images  WHERE divespotID = $id;";
                            
                if ($result2 = mysqli_query($link, $sql2)) {
                    // Fetch each row with the image name of spot images
                            
                    $spot_image_names = []; 
                    while ($row2 = mysqli_fetch_row($result2)) {
                         array_push($spot_image_names ,$row2[0]);                           
                    }
                    mysqli_free_result($result2);
                    $string_image_names = base64_encode(serialize($spot_image_names));
                    //echo $string_image_names;
                    //exit;
                }
                //print_r ($spot_image_names);
                //exit;
                $msg = "";
                $style = "visibility: hidden;";
                require '../app/render_dive_spot.php';
            } else {
                echo "Something went wrong with the variables of spot.";
            }
        } else{
            // Display an error message if divespot doesn't exist
            $id = $name = $depth = $type = $posLat = $posLng = $spot_image_names = $string_image_names = "";
            $msg = "No dive spot found with that name.";
            $style = "visibility: visible;";
            require '../app/index.php';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
?>