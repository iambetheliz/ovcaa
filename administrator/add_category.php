<?php

  include '../includes/dbconnect.php';
  include 'header.php';

  if(!isset($_SESSION['token'])){
    header("Location: index.php?loginError");
  }

  $DB_con = new mysqli("localhost", "root", "", "ovcaa");

  if ($DB_con->connect_errno) {
    echo "Connect failed: ", $DB_con->connect_error;
  exit();
  }
  
  require_once 'dbConnect.php';
              
  $error = false;
   if ( isset($_POST['add_new_cat']) ) {
    
    $cat_name = trim($_POST['cat_name']);
    $cat_name = strip_tags($cat_name);
    $cat_name = htmlspecialchars($cat_name);
    
    if (empty($cat_name)) {
     $error = true;
     $categoryError = "Please enter a Category.";
    } else if (strlen($cat_name) < 5) {
     $error = true;
     $categoryError = "Category must have atleat 5 characters.";
    } 
    else if (!preg_match("/^[a-zA-Z ]+$/",$cat_name)) {
     $error = true;
     $categoryError = "Category must contain alphabets and space.";
    }
   
    else {         
      $query = "SELECT cat_name FROM category WHERE cat_name='$cat_name'";
      $result = $DB_con->query($query);
    
    if($result->num_rows != 0){
            $error = true;
            $categoryError = "Provided Category is already in use.";
      }
    }
   
    if( !$error ) {
      
      require_once 'dbConnect.php';
     
      $stmt = $DB_con->prepare('INSERT INTO category(cat_name) VALUES (:cat_name);');
      $stmt->bindParam(':cat_name',$cat_name);
          if($stmt->execute()) {
            $stmt = $DB_con->query("SELECT LAST_INSERT_ID()");
            $lastId = $stmt->fetchColumn();
            $successMSG = "New category added!";
              header('refresh:3;upload-document.php');
            }
          else {
            $categoryError = "Error!";
            header('refresh:3;upload-document.php');
          } 
      
    }      
   }
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Upload New File - UPOU Scribd</title>
<link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet" media="screen">
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../assets/css/dashboard.css" rel="stylesheet" type="text/css">
<link href="../assets/css/simple-sidebar.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="wrap">
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">

            <!-- Brand and toggle -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#menu-toggle" id="menu-toggle" title="Toggle Sidebar"><span class="glyphicon glyphicon-align-justify"></span></a>
                <a class="navbar-brand" style="color: #f3a22c;" href="/ovcaa/administrator"><img class="img-fluid" alt="Brand" src="images/logo.png" width="40" align="left">&nbsp;&nbsp;UP Open University</a>
            </div>

            <!-- Top Menu Items -->
            <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if(!empty($userData)){?>
                        <li><?php echo $account; ?></li>
                        <li><?php echo $logout; ?></li>
                <?php }?>
            </ul> 
            </ul>
            </div>
            <!-- End of Top Menu Items -->
            
        </div>
        </nav>
        <!-- /.navbar-collapse -->

        <!-- Sidebar Menu Items -->
        <br><br>
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">   
                    <li>
                        <a href="/ovcaa/administrator"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp; Dashboard</a>
                    </li>
                    <li class="active">
                      <a href="javascript:;" data-toggle="collapse" data-target="#demo"><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp; Tables &nbsp;&nbsp;<span class="caret"></span></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="tbl_materials.php"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp; Materials</a>
                            </li>
                            <li>
                                <a href="tbl_users.php"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp; Users</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>            
            
        <!-- Main Screen -->
        <div id="page-content-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><strong>Add New Category</strong></h3>
                    </div>
                </div>
                <!-- /.row -->              

<!-- Main Form -->
<div class="form-group row">
<div class="col-sm-6">
<form method="post" action="" autocomplete="off">

<div class="form-group row">
<div class="col-sm-8"> 
  <?php
    if(isset($successMSG)){
      ?>
      <div class="alert alert-success"><?php echo $successMSG; ?></div>
  <?php
    }
    if(isset($errMSG) && ($error == true)){
      ?>
      <div class="alert alert-danger"><?php echo $errMSG; ?></div> 
  <?php
    }
  ?>
</div>
</div>

<div class="form-group row"> 
  <div class="col-sm-8">
    <strong>Category</strong> <sup class="text-danger">required</sup> 
    <input type="text" class="form-control" name="cat_name" placeholder="Specify category" autofocus />
    <p class="text-danger"><?php echo $categoryError; ?></p>
  </div>
</div>

<div class="form-group row">
  <div class="col-sm-8">
    <button type="submit" id="add" name="add_new_cat" class="btn btn-primary">ADD</button>
  </div>
</div>
</form>
</div>
</div>

</div><!-- /.container-fluid -->
</div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->

<footer>
    <div class="container-fluid">
        <p align="right"><a href="/ovcaa/" target="_blank">UP Open University - Scribd</a> &copy; <?php echo date("Y"); ?></p>
    </div>
</footer>

<!-- jQuery -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $( document ).ready(function() {
        $("#wrapper").addClass("toggled");
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    });
    </script>

</body>
</html>