<?php
  session_start();
  require_once '../includes/dbconnect.php';

  $DB_con = new mysqli("localhost", "root", "", "ovcaa");

  if ($DB_con->connect_errno) {
    echo "Connect failed: ", $DB_con->connect_error;
  exit();
  }
   
  // if session is not set this will redirect to login page
  if( !isset($_SESSION['user']) ) {
      header("Location: /ovcaa/administrator");
  exit;
  }

  // select loggedin members detail
  $res = "SELECT * FROM members WHERE userId=".$_SESSION['user'];
  $result = $DB_con->query($res);

  if ($result->num_rows != 0) {
    $userRow = $result->fetch_array(MYSQLI_BOTH);
  }

  $error = false;

  if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $userName = trim($_POST['userName']);
  $userName = strip_tags($userName);
  $userName = htmlspecialchars($userName);
  
  $userEmail = trim($_POST['userEmail']);
  $userEmail = strip_tags($userEmail);
  $userEmail = htmlspecialchars($userEmail);
  
  $userPass = trim($_POST['userPass']);
  $userPass = strip_tags($userPass);
  $userPass = htmlspecialchars($userPass);
  
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
<style type="text/css">
  .input-group-addon.primary {
    color: rgb(255, 255, 255);
    background-color: rgb(50, 118, 177);
    border-color: rgb(40, 94, 142);
}
.input-group-addon.success {
    color: rgb(255, 255, 255);
    background-color: rgb(92, 184, 92);
    border-color: rgb(76, 174, 76);
}
.input-group-addon.info {
    color: rgb(255, 255, 255);
    background-color: rgb(57, 179, 215);
    border-color: rgb(38, 154, 188);
}
.input-group-addon.warning {
    color: rgb(255, 255, 255);
    background-color: rgb(240, 173, 78);
    border-color: rgb(238, 162, 54);
}
.input-group-addon.danger {
    color: rgb(255, 255, 255);
    background-color: rgb(217, 83, 79);
    border-color: rgb(212, 63, 58);
}
</style>
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $userRow['userName']; ?>&nbsp;&nbsp;<span class="caret"></span></a>
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
                        <h3 class="page-header"><strong>User Profile</strong></h3>
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
    <strong>Username</strong>
    <?php echo $userRow['userName']; ?>
  </div>
</div>

<div class="form-group row"> 
  <div class="col-sm-8">
    <strong>Email</strong>
      <?php echo $userRow['userEmail']; ?>
  </div>
</div>

<div class="form-group row"> 
  <div class="col-sm-8">
    <strong>First Name</strong>
      <?php echo $userRow['first_name']; ?>
  </div>
</div>

<div class="form-group row"> 
  <div class="col-sm-8">
    <strong>Last Name</strong>
      <?php echo $userRow['last_name']; ?>
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