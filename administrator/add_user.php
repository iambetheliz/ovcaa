<?php
    ob_start();
    session_start();
    require_once 'includes/dbconnect.php';
    
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
   $userNameError = "Please enter a username.";
  } else if (strlen($userName) < 5) {
   $error = true;
   $userNameError = "Name must have atleat 5 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$userName)) {
   $error = true;
   $userNameError = "Name must contain alphabets and space.";
  }else {
   // check username exist or not
   $query = "SELECT userName FROM members WHERE userName='$userName'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = true;
    $userNameError = "Provided username is already in use.";
   }
  }
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter a valid email address.";
  } else {
   // check email exist or not
   $query = "SELECT userEmail FROM members WHERE userEmail='$email'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
   }
  }
  // password validation
  if (empty($userPass)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($userPass) < 6) {
   $error = true;
   $passError = "Password must have atleast 6 characters.";
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
<title>Admin - UP Open University</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"  id="onload">

    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
          <?php
  if ( isset($errMSG) || ($error == true)) {
?>
        <div class="modal-header alert alert-danger">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> ERROR!</h4>
        </div>
        <div class="modal-body">
          
  <div class="form-group">
          <?php echo $errMSG; ?>
          <p class="text-danger"><?php echo $userNameError; ?></p>
          <p class="text-danger"><?php echo $emailError; ?></p>
          <p class="text-danger"><?php echo $passError; ?></p>
  </div>
<?php
 }
?>

<?php
  if ( isset($successMSG) ) {
?>
<div class="modal-header alert alert-success">
          <button type="button" class="close" data-dismiss="modal">×</button>
<h4 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> SUCCESS!</h4>
        </div>
        <div class="modal-body">

  <div class="form-group">
      <?php echo $successMSG; ?>
  </div>
<?php
 }
?>
          
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" data-toggle="modal" data-dismiss="modal" data-target="#myModalNorm">GO BACK</button>
          <a class="btn btn-default" role="button" aria-pressed="true" href="tbl_users.php" >Ok</a>
        </div>
      </div>

    </div>
</div>
<?php include 'tbl_users.php'; ?>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
</body>

</html>
