<?php 
 session_start();
 include "partials/_dbconnect.php";
 $username=$_SESSION['username'];
 if($_SERVER['REQUEST_METHOD']=='POST')
{
    $username=$_SESSION['username'];
    $title=$_POST["title"];
    $description=$_POST["description"]; 
    $uno=$_SESSION['sno'];
    $sql="INSERT INTO `$username` (uno,title,description) VALUES ('$uno','$title','$description')";
    $result=mysqli_query($con,$sql);
    if($result) 
     {
       $insert=true;  
     }
     else
      echo "Insertion not happened due to : ".mysqli_error($con);
  }
  header("location:app.php");
?>