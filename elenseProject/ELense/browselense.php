<?php #lenses catalogue
    
    
    include ('includes/header.html');
    require_once ('../mysqli_connect.php');
    // Default query for this page
    $q = "SELECT lense_id,lense_name, lense_price FROM elense.lenses ORDER BY lense_id ASC";
    // Create the table head:
    echo '<table border="0" width="90%" cellspacing="3" cellpadding="3"align="center">
            <tr>
                <td align="left" width="20%"><b>Lense Name</b></td>
                <td align="left" width="20%"><b>Lense Price</b></td>
            </tr>';
        // Display all the lenses, linked to URLs:
       $r = mysqli_query ($dbc, $q); 
       while ($row = mysqli_fetch_array ($r,MYSQLI_ASSOC)) {
           // Display each record:
           echo "\t<tr>
                    <td align=\"left\"><a href=\"viewlense.php?lid={$row['lense_id']}\">{$row['lense_name']}</td>
                    <td align=\"left\">\${$row['lense_price']}</td>

                 </tr>\n";
        } // End of while loop.
    echo '</table>';
    mysqli_close($dbc);
    include ('includes/footer.html');
?>