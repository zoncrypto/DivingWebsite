<?php
// Include config file
require_once "../app/dbconfig.php";
require_once "../app/twig.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$username_err = $confirm_password_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                    echo $twig->render('signup.html', ['error_message' => $username_err, 'style' => "visibility: visible;"]);
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    
    // Validate email
        // Prepare a select statement
        $sql = "SELECT user_id FROM divers WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                    echo $twig->render('signup.html', ['error_message' => $email_err, 'style' => "visibility: visible;"]);
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
        
    // store password
        $password = trim($_POST["password"]);
    
    // Validate confirm password
        $confirm_password = trim($_POST["confirm_password"]);
        if($password != $confirm_password){
            $confirm_password_err = "Password did not match.";
            echo $twig->render('signup.html', ['error_message' => $confirm_password_err, 'style' => "visibility: visible;"]);
        }
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
            // Prepare an insert statement for divers details
                //Find user_id for reference of users table to foreign key in divers table
                $sql = "SELECT id FROM users WHERE username = ?";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $user_id);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
                $sql = "INSERT INTO divers (user_id, fname, lname, birthdate, phone, email) VALUES (?, ?, ?, ?, ?, ?)";
         
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "isssss", $param_user_id, $param_fname, $param_lname, $param_bday, $param_phone, $param_email);
            
                    // Set parameters
                    $param_user_id = $user_id;
                    $param_fname = trim($_POST["fname"]);
                    $param_lname = trim($_POST["lname"]);
                    $param_bday = trim($_POST["bday"]);
                    $param_phone = trim($_POST["phonenumber"]);
                    $param_email = $email;
            
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Redirect to login page
                        $login_msg = "Log in with your new account!";
                        echo $twig->render('login.html', ['error_message' => $login_msg, 'style' => "visibility: visible;"]);
                    } else{
                        echo "Something went wrong. Please try again later.";
                        echo "1";
                    }
                }
            } else{
                echo "Something went wrong. Please try again later.";
                echo "2";
            }
        }


         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>