<?php
session_name('mysession'); 
// Initialize the session
session_start();
// Include config file
require_once "../app/dbconfig.php";
require_once "../app/twig.php";
 
// Define variables and initialize with empty values
// $event_spot = "";
$spot_err = $msg = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    $curr_participants = $_POST["participants"];
    $max_divers = $_POST["maxdivers"];

    if ($curr_participants ==  $max_divers){
$msg = "Maximum number of participants reached.";
                    require '../app/random_spots_index.php';
                    require '../app/event_calendar.php';
                    require '../app/render_diver_main.php';
                    exit;
    }

    // Validate username
    if(empty($spot_err)){
        // Prepare a select statement
        $sql = "select t0.id  from `users` t0 
                inner join `divers` t1 on t0.id = t1.user_id
                where t0.username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_SESSION["username"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id);
                   if(mysqli_stmt_fetch($stmt)){
                    $diver_id = $id;
                    } 
                } else{
                    $msg = "Your user is not a diver.";
                    require '../app/random_spots_index.php';
                    require '../app/event_calendar.php';
                    require '../app/render_diver_main.php';
                    exit;
                }
            }
         
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    
    // Check input errors before inserting in database
    if(empty($spot_err)){
        
        // Prepare an insert statement
                $sql = "INSERT INTO eventparticipants (event_id, diver_id, bookDate) VALUES (?, ?,  CURDATE())";
         
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ii", $param_event_id, $param_diver_id);
            
                    // Set parameters
                    $param_event_id = trim($_POST["event_id"]);
                    $param_diver_id = $diver_id;

            
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Redirect to login page
                        $msg = "Event booked Successfully.";
                        require '../app/random_spots_index.php';
                        require '../app/event_calendar.php';
                        require '../app/render_diver_main.php';
                        exit;
                    } else{
                        echo "Something went wrong. Please try again later.";
                        echo "2";
                    }
                
                } else{
                    echo "Something went wrong. Please try again later.";
                    echo "3";
                }
        


         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>