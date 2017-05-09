<?php

  include 'dbConnect.php';
  include 'header.php';

  if(!isset($_SESSION['token'])){
    header("Location: index.php?loginError");
  }
  
  require_once '../includes/dbconnect.php';

  $DB_con = new mysqli("localhost", "root", "", "ovcaa");

  if ($DB_con->connect_errno) {
    echo "Connect failed: ", $DB_con->connect_error;
  exit();
  }
  
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- jQuery -->
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<!-- end of jQuery -->
</head>
<body>

<?php
    require_once '../includes/dbconnect.php';

    $DB_con = new mysqli("localhost", "root", "", "ovcaa");

    if ($DB_con->connect_errno) {
        echo "Connect failed: ", $DB_con->connect_error;
    exit();
    }

$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;

$per_page = 10; // Set how many records do you want to display per page.

if (isset($_GET['search'])) {

    $search = $_GET['search'];
    $search = $DB_con->real_escape_string($search);

    if (empty($search)) {
            $output = "<div class='row alert alert-danger' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Please enter a keyword.</div>";
        }
    else {
            $output = '<div class="row alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Showing result for <strong>"'.$search.'."</strong></div>';
        }

    $startpoint = ($page * $per_page) - $per_page;

    $statement = "`users` WHERE CONCAT(`uid`, `oauth_uid`, `first_name`, `last_name`, `email`, `created`, `modified`) LIKE '%".$search."%'"; 
 
    $result = mysqli_query($DB_con,"SELECT * FROM {$statement} ORDER BY $field $sort LIMIT {$startpoint} , {$per_page}");
} 
else {

    $startpoint = ($page * $per_page) - $per_page;

    $statement = "users ORDER BY uid"; 
 
    $result = mysqli_query($DB_con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
}
?>  

<div class="container-fluid">

<?php if(!empty($_SESSION['success_msg'])){ ?>
    <div class="alert alert-success"><?php echo $_SESSION['success_msg']; ?></div>
    <?php unset($_SESSION['success_msg']); 
} ?>

<?php
  if(isset($successMSG)){
?>
    <p class="alert alert-success">
       <span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?>
    </p>
<?php
    }
?>

<?php if (isset($_GET['search'])) {
    echo $output;
}  ?>

<div class="row">
<table class="table table-striped table-bordered table-responsive table-hover" id="table-id">
<thead>
    <tr>
        <th><center>Action</center></th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Date Added</th>
        <th>Date Modified</th>
    </tr>
</thead>
<?php
if ($result->num_rows != 0) { ?>

    <tbody>
    <?php 
    // displaying records.
    while ($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><center>
            <a class="btn btn-danger btn-lg active btn-sm" role="button" aria-pressed="true" href="?delete_id=<?php echo $row['uid']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-trash"></span>&nbsp; Delete</a></center>
            </td>
            <td><?php echo $row['first_name'] ?></td>
            <td><?php echo $row['last_name'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['role'] ?></td>
            <td><p><?php echo date('l; F j, Y; g:i a', strtotime($row['created'])) ?></p></td>
            <td><p><?php echo date('l; F j, Y; g:i a', strtotime($row['modified'])) ?></p></td>
<?php
    }
 
} 
else {
     $errMSG = "No files to display.";
}

?>
                <?php
                    if(isset($errMSG)){
                ?>
                    <td colspan="7" class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                    </td>
                <?php
                }
                ?>
        </tr>
    </tbody>
</table>
</div>

<div class="row">
<?php echo pagination($statement,$per_page,$page,$url='?');?> 
</div>

</div> <!-- end of container-fluid -->
</body>
</html>