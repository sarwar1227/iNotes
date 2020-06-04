<?php
  session_start();
  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
     {
       header("location:login.php");
       exit;
     }
?>
<?php
$delete=false;
$username=$_SESSION['username'];
include "partials/_dbconnect.php";

if(isset($_GET['delete']))
{
  $username=$_SESSION['username'];
  $sno=$_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `$username` WHERE `sno`=$sno";
  $result=mysqli_query($con,$sql);
  if(!$result)
    echo "Deletion not happened due to : ".mysqli_error($con);
  header("location:app.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <link rel = "icon" href = "icon.png" type = "image/x-icon">
  <title>iNotes-Notes taking made easy</title> 
</head>
<body>
<?php include 'partials/_nav.php'?>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/sarwar_inotes/update.php" method="POST">
        <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="form-group">
            <label for="titleEdit">Note Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit"  aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label for="descriptionEdit">Note Description</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning">Update Note</button>
      </div>
      </form>
    </div>
  </div>
</div>
 <div class="container my-4">
    <h2>Add a Note to iNotes App</h2>
    <form action="/sarwar_inotes/insert.php" method="POST">
      <div class="form-group">
        <label for="title">Note Title</label>
        <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="description">Note Description</label>
        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-success">Add Note</button>
    </form>
  </div>
  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sno</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
            $username=$_SESSION['username'];
            $sno=0;
            $sql="SELECT * FROM `$username`"; 
            $result=mysqli_query($con,$sql);
            while($row=mysqli_fetch_assoc($result))
            {
              
              $sno=$sno+1;
              echo "<tr>
                     <th scope='row'>".$sno."</th>
                     <td>".$row['title']."</td>
                     <td>".$row['description']."</td>
                     <td>
                       <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button>
                       <button class='delete btn btn-sm btn-danger' id=d".$row['sno'].">Delete</button>
                     </td>
                  </tr>";
            }
            ?>
      </tbody>
    </table>
  </div>
  <hr>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
    crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script> 
  $(document).ready( function () {
    $('#myTable').DataTable(); 
      } );
  </script>
  <script>
    edits=document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>
            {   element.addEventListener('click',(e)=>
                         { 
                            tr=e.target.parentNode.parentNode;
                            title=tr.getElementsByTagName('td')[0].innerText;
                            description=tr.getElementsByTagName('td')[1].innerText;
                            descriptionEdit.value=description;
                            titleEdit.value=title;
                            snoEdit.value=e.target.id;
                            $('#editModal').modal('toggle');
                         })
            })
    </script>
    <script>
    deletes=document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>
            {   element.addEventListener('click',(e)=>
                         { 
                            sno=e.target.id.substr(1,);
                            if(confirm("Are You Sure You Want To Delete This Note?"))
                            {
                              console.log("yes");
                              
                              window.location=`/sarwar_inotes/app.php?delete=${sno}`;
                              //TODO : create a form and Use POST request to submit a form
                            }
                            else
                            {
                              console.log("no");
                            }
                         })
            })
  </script>
<?php include "partials/_footer.php";?>
</html>