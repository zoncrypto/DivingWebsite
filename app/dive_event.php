<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $eventId = $_POST['id'];
} else {
$eventId  = $_GET['id'];
}

session_name('mysession');  
session_start();

// Include config file
require_once "../app/dbconfig.php";
require_once "../app/twig.php";
 
//Check if the logged in user is a diver to render the book button.
if(isset($_SESSION["loggedin"])){
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
                }  else {
                    $center = true;
                }  
            }
         
            // Close statement
            mysqli_stmt_close($stmt);
        }
}
// Prepare a select statement
$sql = "SELECT  t0.id,t0.name,t0.date, t0.maxdivers,t1.name as `diveCenterName`, t2.name as `spotName`,t2.depth,t2.type, COUNT(t3.diver_id)  as `participants`
FROM `diveevents` t0 
        inner join `divecenters` t1 on t0.divecenter = t1.user_id
        inner join `divespots` t2 on t0.divespot = t2.id 
        left join `eventparticipants` t3 on t0.id = t3.event_id
        where t0.id =?      
        group by t0.id,t0.name,t0.date, t0.maxdivers,t1.name , t2.name ,t2.depth,t2.type;";
        
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_name);
    
    // Set parameters
    $param_name = $eventId;
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);
        
        // Check if dive spot exists
        if(mysqli_stmt_num_rows($stmt) == 1){                    
            // Bind result variables
            mysqli_stmt_bind_result($stmt,$id, $name,$date, $maxdivers, $diveCenterName, $spotName, $depth, $type,$participants);
            if(mysqli_stmt_fetch($stmt)){

                //select all participants for this event
                 $sql2 = "SELECT CONCAT(t1.fname,' ',t1.lname) as `diverName` FROM eventparticipants t0 
                 inner join divers t1 on t0.diver_id = t1.user_id  WHERE event_id = $id;";
                            
                if ($result2 = mysqli_query($link, $sql2)) {
                            
                    $divers = []; 
                    while ($row2 = mysqli_fetch_row($result2)) {
                         array_push($divers ,$row2[0]);                           
                    }
                    mysqli_free_result($result2);

                }
                
                $msg = "";
                $style = "visibility: hidden;";
                require '../app/render_dive_event.php';
            } else {
                echo "Something went wrong with the variables of event.";
            }
        } else{
            // Display an error message if dive event doesn't exist
            $id = $name = $date = $maxdivers = $diveCenterName = $spotName = $depth = $type = $participants= $divers = ""; 
            $msg = "No dive event found";
            $style = "visibility: visible;";
            require '../app/index.php';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
?>