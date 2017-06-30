<?php # Script 1.5 - loggedin.php
    session_start(); // Start the session
    
     // The user is redirected here from login.php.
    
    // If no cookie is present, redirect the user: 
    if (!isset($_SESSION['mycustomers_id'])) { 
        // Need the functions to create an absolute URL: 
        require_once ('includes/login_functions.inc.php');
        $url = absolute_url();
        header("Location: $url");
        exit(); // Quit the script.
    }
    echo "<title>e-Lenses Logged In</title>";

    //include the HTML header: 
    include ('includes/header.html'); 
    echo "<p class='logi'>Logged: <span class='rname'>{$_SESSION['first_name']}!</span></p>";
    include ('includes/customerContent.html');
    // Print a customized message:
    include ('includes/footer.html');
 ?>


