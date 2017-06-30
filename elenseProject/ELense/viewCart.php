<?php # Script 0.2 - view_cart.php
 // This page displays the contents of the shopping cart.
 // This page also lets the user update the contents of the cart.
 
 // Set the page title and include the HTML header:
 $page_title = 'View Your Shopping Cart';
 include ('includes/header.html');

 // Check if the form has been submitted (to update the cart):
if (isset($_POST['submitted'])) {
    // Change any quantities:
    foreach ($_POST['qty'] as $k => $v) {
        // Must be integers!
        $lid = (int)$k;
        $qty = (int)$v;
        if ( $qty == 0 ) { // Delete.
            unset($_SESSION['cart'][$lid]);
        } 
        elseif ( $qty > 0 ) { // Change quantity.
        $_SESSION['cart'][$lid]['quantity'] = $qty;
        }
    } // End of FOREACH.
} // End of SUBMITTED IF.
    // Display the cart if it's not empty..
if (!empty($_SESSION['cart'])) {
    // Retrieve all of the information for the prints in the cart:
    require_once ('../mysqli_connect.php');
    $q = "SELECT lense_id, lense_price AS Lense, Price FROM elense.lenses WHERE lenses.lense_id IN (";
        foreach ($_SESSION['cart'] as $lid => $value) {
            $q .= $lid . ',';
        }
        $q = substr($q, 0, -1) . ') ORDER BY lenses.lense_name ASC';
        $r = mysqli_query ($dbc, $q);

        // Create a form and a table:
        echo '
            <form action="viewCart.php" method="post">
            <table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
            <tr>
                <td align="left" width="30%"><b>Lense Name</b></td>
                <td align="right" width="10%"><b>Price</b></td>
                <td align="center" width="10%"><b>Qty</b></td>
                <td align="right" width="10%"><b>Total Price</b></td>
            </tr>
        ';
        // Print each item...
        $total = 0; // Total cost of the order.
        while ($row = mysqli_fetch_array ($r,MYSQLI_ASSOC)) {
            // Calculate the total and sub-totals.
            $subtotal = $_SESSION['cart'][$row['lense_id']]['quantity'] * $_SESSION['cart'][$row['lense_id']]['lense_price'];
            $total += $subtotal;

            // Print the row.
            echo "\t<tr>
                <td align=\"left\">{$row['lense_name']}</td>
                <td align=\"right\">\${$_SESSION['cart'][$row['lense_id']]['lense_price']}</td>
                <td align=\"center\"><input type=\"text\" size=\"3\"name=\"qty[{$row['lense_id']}]\"value=\"{$_SESSION['cart'][$row['lense_id']]['quantity']}\" /></td>
                <td align=\"right\">$" .number_format ($subtotal, 2) ."</td>
            </tr>\n";
        } // End of the WHILE loop.

        mysqli_close($dbc); // Close the database connection.
        // Print the footer, close the table,and the form.
        echo '<tr>
            <td colspan="4"align="right"><b>Total:</b></td>
            <td align="right">$' . number_format($total, 2) . '</td>
        </tr>
        </table>
        <div align="center"><input type="submit" name="submit" value="Update My Cart"/></div>
        <input type="hidden" name="submitted" value="TRUE" />
        </form>
        <p align="center">Enter a quantity of 0 to remove an item.<br /><br /><a href="checkout.php">Checkout</a></p>';
    } 
    else {
        echo '<p>Your cart is currently empty.</p>';  
    }
    include ('includes/footer.html');
?>