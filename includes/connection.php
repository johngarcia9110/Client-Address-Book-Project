<?php 
$server     = "localhost";
$username   = "jgarcia_client";
$password   = "brandon213";
$db         = "jgarcia_clients";

//create a connection
$conn = mysqli_connect( $server, $username, $password, $db );

//check connection
if( !$conn){
    die("Connection failed =( :".mysqli_connect_error());
}else{
    //echo "connected";
}
?>