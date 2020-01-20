<?php

session_name('mysession');  
session_start();

// Include config file
require_once "../app/dbconfig.php";
require_once "../app/twig.php";
 
//Check if the logged in user is a diver to render the book button.
if(isset($_SESSION["loggedin"])){
        // Prepare a select statement
        $sql = "select t0.id  from `users` t0 
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
                    $user_id = $id;
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
$sql = "SELECT  t0.id,t0.name,t0.date,t1.name as `diveCenterName`, t2.name as `spotName`,t2.depth,t2.type,t0.price
        FROM `diveevents` t0 
        inner join `divecenters` t1 on t0.divecenter = t1.user_id
        inner join `divespots` t2 on t0.divespot = t2.id 
        where t1.user_id = $user_id 
        
        union ALL

        SELECT  t0.id,t0.name,t0.date,t1.name as `diveCenterName`, t2.name as `spotName`,t2.depth,t2.type,t0.price
        FROM `diveevents` t0 
        inner join `divecenters` t1 on t0.divecenter = t1.user_id
        inner join `divespots` t2 on t0.divespot = t2.id 
        inner join `eventparticipants` t3 on t3.event_id = t0.id and t3.diver_id =  $user_id;";
        

            $account_details = []; 
        if ($result = mysqli_query($link, $sql)) {
                    
            while ($row = mysqli_fetch_row($result)) {
                    $object = (object) ['id' => $row[0], 'name' => $row[1], 'date' => $row[2], 'diveCenterName' => $row[3], 'spotName' => $row[4], 'depth' => $row[5], 'type' => $row[6], 'price' => $row[7]];

                    array_push($account_details , $object);                           
            }

            mysqli_free_result($result);
        }
        $msg = "";
        $style = "visibility: hidden;";
        require '../app/render_user_account.php';
            
?>