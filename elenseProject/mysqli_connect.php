<?php

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'elense');

//MAKE THE CONNECTION
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: '.mysqli_connect_error());
/*
//run a query and echo a message to see if we are connected
$q = "SELECT * FROM testdb.users";
$r = mysqli_query($dbc, $q);
if ($r){
    echo"connected";
}
mysqli_close($dbc);
*/
?>
