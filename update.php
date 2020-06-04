<?php 
 session_start();
 include "partials/_dbconnect.php";
 $username=$_SESSION['username'];
 if(isset($_POST['snoEdit']))
  {
    $username=$_SESSION['username'];
    $sno=$_POST["snoEdit"];
    $title=$_POST["titleEdit"];
    $description=$_POST["descriptionEdit"]; 
    $sql="UPDATE `$username` SET `title` = '$title', `description` = '$description' WHERE `$username`.`sno` = $sno";
    $result=mysqli_query($con,$sql);
    if($result) 
      {
       $update=true;  
      }
      else
      echo "Updation not happened due to : ".mysqli_error($con);
  }
  header("location:app.php");
?>