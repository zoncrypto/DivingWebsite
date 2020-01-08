<?php
require_once "../app/twig.php";
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ($_SESSION["usertype"] === "diver"){
        //header("location: welcome.php");
        echo $twig->render('welcomediver.html', ['name' => $_SESSION["username"], 'home' => "nav-item active", 
        'services' => "nav-item", 
        'contactus' => "nav-item", 
        'aboutus' => "nav-item",
        'login' => "nav-item" ]); 
        exit;
    }else{
        echo $twig->render('welcomedivecenter.html', ['name' => $_SESSION["username"], 'home' => "nav-item active", 
        'services' => "nav-item", 
        'contactus' => "nav-item", 
        'aboutus' => "nav-item",
        'login' => "nav-item" ]); 
        exit;
    }
}
 
// Include config file
require_once "../app/dbconfig.php";

 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        //printf ("%s (%s)\n", $username, $hashed_password);
                        //echo ("Fetch");
                        if(password_verify($password, $hashed_password)){
                        //if ($password == $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Search if he is a diver or dive center
                            // Prepare a select statement
                            $sql = "SELECT user_id FROM divers WHERE user_id = ?";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "s", $param_id);
                                
                                // Set parameters
                                $param_id = $id;
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    /* store result */
                                    mysqli_stmt_store_result($stmt);
                                    
                                    if(mysqli_stmt_num_rows($stmt) == 1){
                                        $_SESSION["usertype"] = "diver";
                                        echo $twig->render('welcomediver.html', ['name' => $_SESSION["username"], 'home' => "nav-item active", 
                                        'services' => "nav-item", 
                                        'contactus' => "nav-item", 
                                        'aboutus' => "nav-item",
                                        'login' => "nav-item" ]); 
                                    } else{
                                        $_SESSION["usertype"] = "divecenter";
                                        echo $twig->render('welcomedivecenter.html', ['name' => $_SESSION["username"], 'home' => "nav-item active", 
                                        'services' => "nav-item", 
                                        'contactus' => "nav-item", 
                                        'aboutus' => "nav-item",
                                        'login' => "nav-item" ]); 
                                    }
                                } else{
                                    echo "Oops! Something went wrong. Validate diver or dive center.";
                                }
                            }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not correct.";
                            echo $twig->render('login.html', ['error_message' => $password_err, 'style' => "visibility: visible;"]);
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                    echo $twig->render('login.html', ['error_message' => $username_err, 'style' => "visibility: visible;"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        // Close statement
        mysqli_stmt_close($stmt);
        }
        
        

    }
    
    // Close connection
    mysqli_close($link);
}
?>