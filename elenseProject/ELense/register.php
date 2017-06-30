<?php # Script 1.1 - register.php
      
    // This script performs an INSERT query to add a record to the users table.
    //Also check if the user is already registered 
    echo "<title>e-Lenses Register</title>";
    include ('includes/header.html');
    // Check form submission: 
    if($_SERVER['REQUEST_METHOD']=='POST'){
    if (isset($_POST['submitted'])){
        $errors = array(); //Initialize an error array.
        // Check for a first name:
        if (empty($_POST['first_name'])) { 
            $errors[] = 'You forgot to enter your first name.';
        }
        else{
            $fn = trim($_POST['first_name']);
        }  
        // Check for a last name:
        if (empty($_POST['last_name'])){
            $errors[] = 'You forgot to enter your last name.';
        }
        else{
            $ln = trim($_POST['last_name']);
        }
        // Check for an email address:
        if (empty($_POST['email'])){
            $errors[] = 'You forgot to enter your email address.';
        }
        else{
            $e = trim($_POST['email']);
        }
        // Check for a password and match against the confirmed password:
        if (!empty($_POST['pass1'])){
            if($_POST['pass1'] != $_POST['pass2']){
                $errors[] = 'Your password did not match the confirmed password.';
            }
            else{
                $p = trim ($_POST['pass1']);
            }
        }
        else{
            $errors[] = 'You forgot to enter a password.';
        }
        if (empty($errors)){ //everything is OK
            //Register the user in the data base...
            require_once('../mysqli_connect.php'); //Connect to the db

            
            ////////////////////////////////check if email exists\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
            $rt = "SELECT email FROM elense.mycustomers WHERE email='$e'"; //make the query
            $result = $dbc->query($rt);
            /*ERROR HANDLING JUST IN CASE
            //$query = mysqli_query($dbc, $rt);// Run the query.
            //if($result){echo "<h2>good!</h2>";}//MESSAGE IF THE QUERY $rt run
            END OF ERROR HANDLING */
            if( mysqli_num_rows($result) > 0){

                echo "<h1 class='error'>Error!</h1><p class='error'>email already exists, try again !</p>";
                die();
            
            }
            //////////////////////////////end of check email IF exists\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

            //If there is no match with the email insert record to mycustomers table
            /////////////////////////////////////////Make the query:\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
            $q = "INSERT INTO elense.mycustomers (first_name, last_name, email, pass, registration_date) VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW())";
            $r = @mysqli_query ($dbc, $q); // Run the query.
            if ($r){ //if it ran OK
                //Print a message:
               
                echo "<h1>Thank you!</h1><p>You are now registered <em>$fn!</em></p><p><br/></p>";
                include ('includes/content.html');
            }
            else{ //if it did not run OK
                //Public message:
                echo '<h1>OOOps System Error</h1><p class="error">You could not be registered due to a system error.</p>';
                //Debugging message:
                echo '<p>'.mysqli_error($dbc).'<br/><br/>Query: '.$q.'</p>';
            }//End of if ($r) IF.
            mysqli_close($dbc); //close the db connection
            //include the footer and quit the script:
            include ('includes/footer.html');
            exit();
             
        }
        else{ //Report the errors.
            echo '<h1 class="error">OOOps Error!</h1><p class="error">The following error(s) occurred:<br/>';
            foreach ($errors as $msg){ //Print each error.
                echo " - $msg<br/>\n";
            }
            echo '<p class="error">Please try again</p><p><br/></p>';
        } // End of if (empty($errors))
    } //End of main Submit conditional.
    }
?>
<!--RegisterForm-->
<div class="logReg">
    <h1>Register </h1>
    <form action="register.php" method="post">
        <p>First Name:<input type="text" name="first_name" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>
        <p>Last Name:<input type="text" name="last_name" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
        <p>Email Address:<input type="text" name="email" size="20" maxlength="80" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></p>
        <p>Password:<input type="password" name="pass1" size="10" maxlength="20" /></p>
        <p>Confirm Password:<input type="password" name="pass2" size="10" maxlength="20" /></p>
        <p><input class="button" type="submit" name="submit" value="Register" /></p>
        <input type="hidden" name="submitted" value="TRUE" />
    </form>
</div>
<?php
include ('includes/footer.html');
?>