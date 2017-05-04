<?php

  include 'dbConnect.php';
  include 'header.php';
  
  require_once '../includes/dbconnect.php';

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

  $role = 'admin';
  
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
   
   $stmt = $DB_con->prepare("INSERT INTO users(email,role) VALUES('$email','$role')");
   $stmt->bind_param($email);
   $stmt->bind_param($role);
    
   if (!$stmt) {
      $errMSG = "Something went wrong, try again later..."; 
   } else {
      $stmt->execute();
      $successMSG = "User created successfully!";
        header("refresh:3; index.php");
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

<form id="regValidate" method="post" autocomplete="off">

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
      <input type="text" id="email" name="email" class="form-control" title="Please enter the valid email format (e.g. example@email.com)" maxlength="25" value="<?php echo $email ?>" />
      <p class="text-danger"><?php echo $emailError; ?></p>
      <input hidden="" type="text" name="role" value="$role" />
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

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>

</body>
</html>
<?php ob_end_flush(); ?>