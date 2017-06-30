
<?php # Script 1.6 - logout.php
// This page processes the log out submission.

    session_start(); // Access the existing session.
    
    
    if (!isset($_SESSION['mycustomers_id'])) {
        require_once ('includes/login_functions.inc.php');
        $url = absolute_url();
        header("Location: $url");
        exit();
    }
    else{// Cancel the session.
        $_SESSION = array(); // Clear the variables.
        session_destroy(); // Destroy the session itself.
        setcookie ('PHPSESSID', '', time()-3600,'/', '', 0, 0); // Destroy the cookie.
    }
    // Set the page title and include the HTML header:
    echo "<title>e-Lenses Logged Out</title>";
    include ("includes/header.html");

    //Print message
    echo "<p class='logou'>Thank you for visiting us!</p>";
    include("includes/footer.html");  
 ?>
