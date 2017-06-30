
<?php # Script 0.1 - add_cart.php
    // This page adds lenses to the shopping cart.
    
    echo "<title>e-Lenses Your Basket</title>";
    include ('includes/header.html');

    if (isset ($_GET['lid']) && is_numeric($_GET['lid']) ) { // Check for a lense ID.
        $lid = (int) $_GET['lid'];
        // Check if the cart already contains one of these lenses;

        // If so, increment the quantity:
        if (isset($_SESSION['cart'][$lid])) {
            $_SESSION['cart'][$lid]['quantity']++;// Add another.
            // Display a message.
            echo '<p>Another lense has been added to your shopping cart.</p>';
        } 
        else { // New product to the cart.
            // Get the lenses's price from the database:
            require_once ('../mysqli_connect.php');
            $q = "SELECT lense_price FROM elense.lenses WHERE elense.lense_id = $lid";
            $r = mysqli_query ($dbc, $q);
            if (mysqli_num_rows($r) == 1) {
                // Valid lense ID.
                // Fetch the information.
                list($price) = mysqli_fetch_array($r, MYSQLI_NUM);
                // Add to the cart:
               $_SESSION['cart'][$lid] = array('quantity' => 1, 'price'=> $price); 
               // Display a message:
               echo '<p>The lense has been added to your shopping cart.</p>';
            } 
            else { // Not a valid lense ID.
                echo '<div>This page has been accessed in error!</div>';
            }
            mysqli_close($dbc);
        }// End of isset($_SESSION['cart'][$lid] conditional.
    }
    else{// No print ID.
        echo '<div>This page has been accessed in error!</div>';
    }
    include ('includes/footer.html');
?>