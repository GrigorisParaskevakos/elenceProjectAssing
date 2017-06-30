<?php # Script 1.3 loginPage.inc.php 

    // This page prints any errors associate with logging in 
    // and it creates the entire login page,including the form. 

    //include the title
    echo "<title>e-Lenses Logg In</title>";

    //includes the header
    include ('includes/header.html');
    // Print any error messages, if they exist:
    if (!empty($errors)) {
        echo '<h1 class="error">Error!</h1>
        <p class="error">The following error(s) occurred:<br />';
        foreach ($errors as $msg) {
            echo " - $msg<br />\n";
        }
        echo '</p><p class="error">Please try again.</p>';
    }
?>

<!-- Display the form:-->
<div class="logReg">
    <h1>Login</h1>
    <form action="login.php" method="post">
        <p>Email Address:<input type="text" name="email" size="20" maxlength="80" /></p>
        <p>Password:<input type="password" name="pass" size="20" maxlength="20" /></p>
        <p><input class="button" type="submit" name="submit" value="Login" /></p>
        <input type="hidden" name="submitted" value="TRUE" />
    </form>
</div>

<!-- Include the footer -->
<?php 
    include ('includes/footer.html');
?>