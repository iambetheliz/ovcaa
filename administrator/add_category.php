<?php
            
$error = false;

 if ( isset($_POST['add_new_cat']) ) {
  
  // clean user inputs to prevent sql injections
  $cat_name = trim($_POST['cat_name']);
  $cat_name = strip_tags($cat_name);
  $cat_name = htmlspecialchars($cat_name);
       
  // basic username validation

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
   // check username exist or not
   $query = "SELECT cat_name FROM category WHERE cat_name='$cat_name'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = true;
    $categoryError = "Provided Category is already in use.";
   }
  }
 
  // if there's no error, continue to signup
  if( !$error ) {
   
    $stmt = $DB_con->prepare('INSERT INTO category(cat_name) VALUES (:cat_name)');
                  $stmt->bindParam(':cat_name',$cat_name);
                  if($stmt->execute())
                      {
                        header('refresh:1;upload-document.php');
                      }
                  else
                      {
                        $errMSG = "Error!";
                        header('refresh:1;upload-document.php');
                      } 
    
  }  
  
 }

 ?>


