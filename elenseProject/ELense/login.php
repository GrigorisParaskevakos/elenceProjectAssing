<?php # Script 1.4 - login.php

    // This page PROCESSES the login form submission.
    // Upon successful login, the user is redirected TO login.php
    // *Two included files are necessary.
    // Send NOTHING to the Web browser prior to the setcookie() lines!


    // Check if the form has been submitted:
    if (isset($_POST['submitted'])) {
        // For processing the login:
        require_once ('includes/login_functions.inc.php'); //*1st included file
        // Need the database connection:
        require_once ('../mysqli_connect.php');

        // Check the login:
        list ($check, $data) = check_login($dbc,$_POST['email'], $_POST['pass']);
        if ($check) { // OK!

            
            //set the session data:
            session_start();
            $_SESSION['mycustomers_id'] = $data['mycustomers_id'];
            $_SESSION['first_name'] = $data['first_name'];
            $_SESSION['cart'] = $data['lense_id']['quantity']['price'];
            

            // Redirect:
            $url = absolute_url ('./loggedin.php');
            header("Location: $url");
            exit(); // Quit the script.
        } 
        else { // Unsuccessful!
            // Assign $data to $errors for error reporting
            // in the loginPage.inc.php file.
            $errors = $data;
        }
        mysqli_close($dbc); // Close the database connection.
    } // End of the main submit conditional.
    
    // Create the page:
    include ('loginPage.inc.php'); //*2nd included file
?>
