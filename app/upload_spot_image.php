<?php
session_name('mysession'); 
// Initialize the session
session_start();

// -- keep spot variables --//
$id  = $_POST['spot_id'];
$name  = $_POST['spot_name'];
$depth  = $_POST['depth'];
$type  = $_POST['spot_type'];
$posLat = $_POST['posLat'];
$posLng  = $_POST['posLng'];
// keep spot variables - end//



$max_size = $_POST['max_size'];
echo $id;


// Include config file
require_once "../app/dbconfig.php";

// Initialize message variable
  $msg = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
      $image = $_FILES['image']['name'];
      $strip_image = str_replace(' ', '_', $image);
      $size= $_FILES['image']['size'];

  	// image file directory
  	$target = "../spotimages/".basename($strip_image);

      

    if (isset($strip_image)) {
        echo "1";

        if ($size < $max_size) {
            if (copy($_FILES['image']['tmp_name'], $target)) {
                $sql = "INSERT INTO images (image, divespotID) VALUES ('$strip_image', '$id')";
                // execute query
                mysqli_query($link, $sql);
                $msg = "Image uploaded successfully";
                $style = "visibility: visible;";
                echo "2";
                require '../app/render_dive_spot.php';
                
            }else{
                $msg = "Failed to upload image";
                $style = "visibility: visible;";
                echo "3";
                require '../app/render_dive_spot.php';
            }
        }
        else
        {
            $msg = "The size of the file must be less than 3MB in order to be uploaded.";
            $style = "visibility: visible;";
            echo "4";
            require '../app/render_dive_spot.php';	
        }
    }

  }


?>