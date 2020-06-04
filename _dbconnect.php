<?php
$username="root";
$password="";
$database="users";
$server="localhost";
$con=mysqli_connect($server,$username,$password,$database);
if(!$con)
{
   die("Unable to connect ".mysqli_connect_error($con));
}
?>