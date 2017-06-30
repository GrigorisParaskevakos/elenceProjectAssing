<!-- This page lets Administrator add a lense product to the elense.db -->

<?php #include title and header.html
    echo "<title>Admin Add Product-Lense</title>";
    include ("includes/header.html");
?>

<?php # Script 0 addLense.php 

    //for SECURITY we should use the mysqli_connect.php outside the htdocs as ('../../mysqli_connect.php')
    //but for the assignment purposes we use it inside  htdocs
    require_once ('../mysqli_connect.php'); 
    if (isset($_POST['submitted'])) { // Handle the form   
        // Validate the incoming data...
        $errors = array();

        // Check for a lense name\\
        if (!empty($_POST['lense_name'])) {
            $ln = trim($_POST['lense_name']);
        }
        else{
            $errors[] = 'Please enter the lense name';
        }
        
        //Check for a price\\
        if(is_numeric($_POST['lense_price'])){
            $p = (float)$_POST['lense_price'];
        }
        else{
            $errors[] = 'Please enter the lense\'s price!';
        }
        
        //If everything goes well
        if(empty($errors)){
            
            //Add the Lense to the lenses database
            $q = 'INSERT INTO elense.lenseorders (lense_name, lense_price) VALUES (?,?)';
            $stmt = mysqli_prepare($dbc,$q) ;

            //mysqli_stmt::bind_param -- mysqli_stmt_bind_param — Binds variables to a prepared statement as parameters
            // 'sd' means s for string, d for double (aka float)
            mysqli_stmt_bind_param($stmt, 'sd', $ln, $p);
            mysqli_stmt_execute($stmt);

            //Check the results
            if(mysqli_stmt_affected_rows($stmt) == 1){
                //Print a message
                echo'<p>The Lense has beed added!</p>';
                
                //Clear $_POST
                $_POST = array();
            }
            else{//ERROR
                echo '<p class="error">Your submission FAILED due to system error</p>';
            }
            mysqli_stmt_close($stmt);
        }//End $errors IF
    }// End IF submission 

    // Check for any errors and print them
    if(!empty($errors) && is_array($errors)){
        echo '<p class="error">The following error(s) occurred:<br/>';
        foreach($errors as $msg){
            echo " -$msg<br />\n";
        }
    }
?>
<!-- Display the FORM-->
<div class="logReg">
    <h1>Add Lense</h1>
    <form action="addLense.php" method="post">
        
        <fieldset>
            <legend>Fill out the form to add a Lense to your database catalogue:</legend>
            <p>Lense Name:<input type="text" name="lense_name" size="30" maxlength="60" value="<?php if (isset($_POST['lense_name'])) echo htmlspecialchars($_POST['lense_name']);?>"/></p>
            <p>Price:<input type="text" name="lense_price" size="10" maxlength="10" value="<?php if(isset($_POST['lense_price'])) echo $_POST['lense_price']; ?>" /> <small>Do not include the dollar sign or commas.</small></p>
        </fieldset>
        <div><input type="submit" name="submit" value="ADD" /></div>
        <input type="hidden" name="submitted" value="TRUE" />
    </form>
</div>
<?php
    include ("includes/footer.html");
?>