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
  if ( empty($email) ) {
   $error = true;
   $emailError = "<span class='glyphicon glyphicon-info-sign'></span> Please input email address.";
  } 
  elseif ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "<span class='glyphicon glyphicon-info-sign'></span> Please enter a valid email address.";
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
   
   $stmt = $DB_con->prepare("INSERT INTO users(email,role) VALUES('$email','$role')");
   $stmt->bind_param($email);
   $stmt->bind_param($role);
    
   if (!$stmt) {
      $errMSG = "Something went wrong, try again later..."; 
   } else {
      $stmt->execute();
      $successMSG = "<span class='glyphicon glyphicon-ok'></span> User created successfully!<br><br>";
        header("refresh:3; /ovcaa/administrator");
        unset($email);
  }  }
  
 }
?>
<?php ob_end_flush(); ?>