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
    $res = $DB_con->query("SELECT * FROM members WHERE userId=".$_SESSION['user'], MYSQLI_USE_RESULT);
    $userRow = $res->fetch_array(MYSQLI_BOTH);
?>
<?php

 $error = false;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $userName = trim($_POST['userName']);
  $userName = strip_tags($userName);
  $userName = htmlspecialchars($userName);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $userPass = trim($_POST['userPass']);
  $userPass = strip_tags($userPass);
  $userPass = htmlspecialchars($userPass);
  
  // basic username validation
  if (empty($userName)) {
   $error = true;
   $userNameError .= "<span class='glyphicon glyphicon-exclamation-sign'></span> ";
   $userNameError .= "Please enter a username.";
  } else if (strlen($userName) < 5) {
   $error = true;
   $userNameError = "<span class='glyphicon glyphicon-info-sign'></span> Username must have atleat 5 characters.";
  }else {
   // check username exist or not
   $query = "SELECT userName FROM members WHERE userName='$userName'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = true;
    $userNameError = "<span class='glyphicon glyphicon-info-sign'></span> Provided username is already in use.";
   }
  }
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "<span class='glyphicon glyphicon-info-sign'></span> Please enter a valid email address.";
  } 
  else if (strlen($userEmail) > 30) {
   $error = true;
   $userNameError = "<span class='glyphicon glyphicon-info-sign'></span> That was a very long email address! Please try a shorter one";
  }
  else {
   // check email exist or not
   $query = "SELECT userEmail FROM members WHERE userEmail='$email'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = true;
    $emailError = "<span class='glyphicon glyphicon-info-sign'></span> Provided email is already in use.";
   }
  }

  // password validation
  if (empty($userPass)){
   $error = true;
   $passError = "<span class='glyphicon glyphicon-info-sign'></span> Please enter password.";
  } else if(strlen($userPass) < 8) {
   $error = true;
   $passError = "<span class='glyphicon glyphicon-info-sign'></span> Password must have atleast 8 characters.";
  }
  
  // password encrypt using SHA256();
  $userPass = hash('sha256', $userPass);
  
  // if there's no error, continue to signup
  if( !$error ) {
   
   $query = "INSERT INTO members(userName,userEmail,userPass) VALUES('$userName','$email','$userPass')";
   $res = mysql_query($query);
    
   if ($res) {
    $errTyp = "success";
    $successMSG = "Successfully registered, you may login now";
    header("refresh:3; tbl_users.php");
    unset($userName);
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
                            <a href="logout.php?logout">Logout</a>
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
<div class="col-sm-4">
<form id="regValidate" method="post" action="add_user.php" autocomplete="off">

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
  <label>Username</label>
  <div class="input-group" data-validate="userName">
      <input type="text" id="userName" name="userName" class="form-control" maxlength="15" value="<?php echo $userName ?>" autofocus />
      <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
  </div>
      <p class="text-danger"><?php echo $userNameError; ?></p>
</div>

  <div class="form-group">
  <label>Email</label>
  <div class="input-group" data-validate="email">
      <input type="text" id="email" name="email" class="form-control" title="Please enter the valid email format (e.g. example@email.com)" maxlength="25" value="<?php echo $email ?>" />
      <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
     </div>
      <p class="text-danger"><?php echo $emailError; ?></p>
  </div>

  <div class="form-group">
  <label>Password</label> (atleast 8 characters)
    <div class="input-group" data-validate="userPass">
      <input type="password" class="form-control" name="userPass" id="userPass" autocomplete="off" /><span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
    </div>      
    <p class="text-danger"><?php echo $passError; ?></p>
</div>

  <br>
  <div class="form-group">
    <a type="button" href="tbl_users.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>
  CANCEL </a>&nbsp;
    <button type="submit" class="btn btn-success send" name="btn-signup" data-loading-text="Saving info"><span class='glyphicon glyphicon-thumbs-up'></span> Save </button>
  </div>
</form>
</div>

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