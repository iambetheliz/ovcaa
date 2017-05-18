<?php

  include '../includes/dbconnect.php';
  include 'header.php';

  if(!isset($_SESSION['token'])){
    header("Location: index.php?loginError");
  }

  require_once 'dbConnect.php';

  $DB_con = new mysqli("localhost", "root", "", "ovcaa");

  if ($DB_con->connect_errno) {
    echo "Connect failed: ", $DB_con->connect_error;
  exit();
  }
  
  $error = false;

  if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "<span class='glyphicon glyphicon-info-sign'></span> Please enter a valid email address.";
  } 
  else if (strlen($email) > 30) {
   $error = true;
   $userNameError = "<span class='glyphicon glyphicon-info-sign'></span> That was a very long email address! Please try a shorter one";
  }
  else {
   // check email exist or not
   $query = "SELECT email FROM users WHERE email='$email'";
   $result = $DB_con->query($query);

   if($result->num_rows != 0){
    $error = true;
    $emailError = "<span class='glyphicon glyphicon-info-sign'></span> Provided email is already in use.";
   }
  }
  
  // if there's no error, continue to signup
  if( !$error ) {

    error_reporting(~E_NOTICE || ~E_ALL);
   
   $stmt = $DB_con->prepare("INSERT INTO users(email) VALUES('$email')");
   $stmt->bind_param($email);
    
   if (!$stmt) {
      $errMSG = "Something went wrong, try again later..."; 
   } else {
      $stmt->execute();
      $successMSG = "<span class='glyphicon glyphicon-ok'></span> User created successfully!";
        header("refresh:1; tbl_users.php");
        unset($email);
  }  }
  
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
<title>Users: New - UP Open University</title>
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
                        <h3 class="page-header"><strong>Add New User</strong></h3>
                    </div>
                </div>
                <!-- /.row -->              

<!-- Main Form -->
<div class="form-group row">
<div class="col-sm-6">
<form id="regValidate" method="post" action="add_user.php" autocomplete="off">

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
    <strong>Email</strong><sup class="text-danger">*</sup>    
      <input type="text" id="email" name="email" class="form-control" title="Please enter the valid email format (e.g. example@email.com)" maxlength="25" value="<?php echo $email ?>" autofocus />
      <p class="text-danger"><?php echo $emailError; ?></p>
  </div>
</div>

<br>
<div class="form-group row">
  <div class="col-sm-8">
    <a type="button" href="tbl_users.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>
  CANCEL </a>&nbsp;
    <button type="submit" class="btn btn-success send" name="btn-signup" data-loading-text="Saving info"><span class='glyphicon glyphicon-thumbs-up'></span> Save </button>
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
<?php ob_end_flush(); ?>