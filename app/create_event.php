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
 
    // Validate username
        // Prepare a select statement
        $sql = "SELECT id, name, depth, type FROM divespots WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_spot_name);
            
            // Set parameters
            $param_spot_name = trim($_POST["divespot"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $spot_id, $spot_name, $spot_depth, $spot_type);
                    if(mysqli_stmt_fetch($stmt)){
                    //$event_spot = trim($_POST["divespot"]);
                    $event_spot_id = $spot_id;
                    $event_spot_name = $spot_name;
                    $event_spot_depth = $spot_depth;
                    $event_spot_type = $spot_type;
                    } else{
                        $spot_err = "This dive spot does not exist.";
                        //echo $twig->render('signup.html', ['error_message' => $username_err, 'style' => "visibility: visible;"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
         
            // Close statement
            mysqli_stmt_close($stmt);
        }

    
    
    // Check input errors before inserting in database
    if(empty($spot_err)){
        
        // Prepare an insert statement
                $sql = "INSERT INTO diveevents (name, date, maxdivers, divespot, divecenter) VALUES (?, ?, ?, ?, ?)";
         
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssiii", $param_event_name, $param_event_date, $param_event_maxdivers, $param_event_divespot, $param_event_divecenter);
            
                    // Set parameters
                    $param_event_name = trim($_POST["name"]);
                    $param_event_date = trim($_POST["date"]);
                    $param_event_maxdivers = trim($_POST["maxdivers"]);
                    $param_event_divespot = $event_spot_id;
                    $param_event_divecenter = $_SESSION['id'];
            
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Redirect to login page
                        $msg = "Event Created Successfully.";
                        echo "1";
                        exit;
                        //echo $twig->render('login.html', ['error_message' => $login_msg, 'style' => "visibility: visible;"]);
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