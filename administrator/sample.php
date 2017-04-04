<?php
    ob_start();
    session_start();
    require_once '../includes/dbconnect.php';
    
    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin members detail
    $res=mysql_query("SELECT * FROM members WHERE userId=".$_SESSION['user']);
    $userRow=mysql_fetch_array($res);
?>
<?php

 $error = false;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $cat_name = trim($_POST['cat_name']);
  $cat_name = strip_tags($cat_name);
  $cat_name = htmlspecialchars($cat_name);
       
  // basic username validation

  if (empty($cat_name)) {
   $error = true;
   $userNameError = "Please enter a username.";
  } else if (strlen($cat_name) < 5) {
   $error = true;
   $userNameError = "Username must have atleat 5 characters.";
  } 
  else if (!preg_match("/^[a-zA-Z ]+$/",$cat_name)) {
   $error = true;
   $userNameError = "Name must contain alphabets and space.";
  }
 
  else {
   // check username exist or not
   $query = "SELECT cat_name FROM category WHERE cat_name='$cat_name'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = true;
    $userNameError = "Provided username is already in use.";
   }
  }

 
  // if there's no error, continue to signup
  if( !$error ) {
   
   $query = "INSERT INTO category(cat_name) VALUES('$cat_name')";
   $res = mysql_query($query);
    
   if ($res) {
    $errTyp = "success";
    $successMSG = "Successfully registered, you may login now";
    header("refresh:3; sample.php");
    unset($cat_name);
    unset($email);
    unset($userPass);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
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
<title>Users: New - UP Open University</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                <a class="navbar-brand" style="color: #f3a22c;" href="/ovcaa/administrator"><img class="img-fluid" alt="Brand" src="images/logo.png" width="40" align="left">&nbsp;&nbsp;UP Open University</a>
            </div>

            <!-- Top Menu Items -->
            <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $userRow['cat_name']; ?>&nbsp;&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            </div>

            <!-- Sidebar Menu Items -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
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
            
        </div>
        </nav>
        <!-- /.navbar-collapse -->
        
        <br><br>
        <!-- Main Screen -->
        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><strong>Add New User</strong></h3>
                    </div>
                </div>
                <!-- /.row -->              

<!-- Main Form --> 
<br>

<form name="my_form" method="post" action="sample.php" autocomplete="off">

<?php
  if ( isset($successMSG) ) {
?>
<div class="form-group">
      <?php echo $successMSG; ?>
</div>
<?php
 }
?>

<?php
  if ( isset($errMSG) || ($error == true)) {
    echo $errMSG; 
  }
?>

 <div class="form-group">
    <div class="input-group col-sm-4">
      <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
      <input type="text" name="cat_name" class="form-control" placeholder="Category" maxlength="20" value="<?php echo $cat_name ?>" onkeyup="check(this, '20');" autofocus />
    </div>
      <p class="text-danger"><?php echo $userNameError; ?></p>
        </div>

   
  <br>
  <div class="form-group">
    <a type="button" href="sample.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>
  CANCEL </a>
    <button type="submit" class="btn btn-success" name="btn-signup">Save and Close</button>
  </div>
</form>

</div><!-- /.container-fluid -->
        </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->
</div>

    <footer class="footer">
        <div class="container-fluid">
            <p align="right">UP Open University - Scribd &copy; <?php echo date("Y"); ?></p>
        </div>
    </footer>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>

</body>
</html>
<?php ob_end_flush(); ?>