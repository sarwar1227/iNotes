<?php
  include "partials/_dbconnect.php";
  $login=false;
  $showError=false;
  if($_SERVER['REQUEST_METHOD']=="POST")
  {
      $username=$_POST['username'];
      $password=$_POST['password'];
      $exists=false; 
      $sql="SELECT * FROM users.users WHERE `username`='$username'";
      $result=mysqli_query($con,$sql);
      $num=mysqli_num_rows($result);
      if($num==1)
      {
          while($row=mysqli_fetch_assoc($result))
          {
              if(password_verify($password,$row['password']))
              {
                $login=true;
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['username']=$username;
                $_SESSION['sno']=$row['sno'];
                header("location:app.php");
               }
              else
               {
                $showError="Invalid Credentials !!";
               }
          }
        }   
      else
      {
          $showError="Invalid Credentials !!";
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
        <title>Login</title>
</head>

<body>
    <?php require 'partials/_nav.php'?>
    <?php
       if($login)
       {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>SUCCESS </strong> You are logged in !!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>';
       }
       if($showError)
       {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Danger </strong> '.$showError.'!!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>';
       }
    ?>
    </div>
    <div class="container my-4">
        <h1 class="text-center">Login to Our Website</h1>
        <form action=/sarwar_inotes/login.php method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-info">Login</button>
        </form>
    </div>


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