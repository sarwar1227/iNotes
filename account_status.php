<?php
  include "partials/_dbconnect.php";
  $showAlert=false;
  $showError=false;
  if($_SERVER['REQUEST_METHOD']=="POST")
  {
      $username=$_POST['username'];
      $password=$_POST['password'];
      $cpassword=$_POST['cpassword'];
      $existSql="SELECT * FROM users.users WHERE username='$username'";
      $result=mysqli_query($con,$existSql);
      $numExistRows=mysqli_num_rows($result);
      if($numExistRows>0)
        { 
            $showError="Username Already Exists."; 
        }
      else
        { 
            $exist=false;
            if($password==$cpassword && $exist==false)
             {
                $hash=password_hash($password,PASSWORD_DEFAULT);
                $sql="INSERT INTO users.users(`username`,`password`) VALUES ('$username','$hash')";
                $result=mysqli_query($con,$sql);
                if($result)
                {
                  $create_table="CREATE TABLE users.`$username`(`uno` INT NOT NULL , `sno` INT(11) NOT NULL AUTO_INCREMENT,`title`  VARCHAR(50) NOT NULL,`description` TEXT NOT NULL , PRIMARY KEY(`sno`)) ENGINE=InnoDB";
                  $result=mysqli_query($con,$create_table);
                  if(!$result)
                     echo "Table Creation Failed due to : ".mysqli_error($con);
                  $alter_table="ALTER TABLE users.`$username` ADD CONSTRAINT `uno` FOREIGN KEY(`uno`) REFERENCES `users`.`users`(`sno`)";
                  $result=mysqli_query($con,$alter_table);
                  if(!$result)
                    echo "Alter Table Failed due to : ".mysqli_error($con);
                  $showAlert=true;
                }
            }
            else
            {
               $showError="Passwords do not match.";
            }
        }
    }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel = "icon" href = "icon.png" type = "image/x-icon">
    <title>Account Status</title>
</head>

<body>
    <?php require 'partials/_nav.php'?>
    <?php
       if($showAlert)
       {
        echo '<div class="alert alert-success" role="alert">
        <h4 class="alert-heading">CONGRATULATIONS!</h4>
        <p>Your Account is successfuly created.</p>
        <hr>
        <p class="mb-0">Click <a href="login.php">Here</a> to Login </p>
      </div>';
       }
       if($showError)
       {
        echo '<div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">OOPS !</h4>
        <p>'.$showError.'</p>
        <hr>
        <p class="mb-0">Click <a href="signup.php">Here</a> to Try Again </p>
      </div>';
      }
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
    <?php include "partials/_footer.php";?>
</html>