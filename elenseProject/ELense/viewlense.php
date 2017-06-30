<?php # Script 17.6 - view_lense.php
    
// This page displays the details for a particular lense.

    $row = FALSE; // Assume nothing!
     if (isset($_GET['lid']) &&is_numeric($_GET['lid']) ) { // Make sure there's a lense ID!
        $lid = (int) $_GET['lid'];

        // Get the lense info:
        require_once ('../mysqli_connect.php');
        $q = "SELECT lense_id, lense_name, lense_price FROM elense.lenses ORDER BY lense_id ASC";
        $r = mysqli_query ($dbc, $q);
        if (mysqli_num_rows($r) == 1) { // Good to go!

             // Fetch the information:
            $row = mysqli_fetch_array ($r,MYSQLI_ASSOC);

            // Start the HTML page:
            $page_title = $row['lense_name'];
            include ('includes/header.html');

            // Display a header:
            echo "<div align=\"center\"><b>{$row['lense_name']}</b> at {$row['lense_price']}<br />";
            echo "<br />\${$row['lense_price']}
            <a href=\"addCart.php?lid=$lid\">Add to Cart</a></div><br />";
            // Get the image information and display the image:

        } // End of the mysqli_num_rows() IF.
        mysqli_close($dbc);
    }
    if (!$row) { // Show an error message.
        $page_title = 'Error';
        include ('includes/header.html');
        echo '<div align="center">This page has been accessed in error!</div>';
    }
    // Complete the page:
    include ('includes/footer.html');
?>