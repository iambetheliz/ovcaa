<?php
    ob_start();
    session_start();
    require_once '../includes/dbconnect.php';
    
    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: /ovcaa/administrator");
        exit;
    }
    // select loggedin members detail
    $res=mysql_query("SELECT * FROM members WHERE userId=".$_SESSION['user']);
    $userRow=mysql_fetch_array($res);
?>
<?php
 error_reporting( ~E_NOTICE ); // avoid notice
 require_once 'Material.php';
 
 if(isset($_POST['btn-upload']))
 {
    $cat_name = $_POST['cat_name'];
    
   if(empty($cat_name)){
   $errMSG = "Please Enter Category.";   
  }
  else if (strlen($cat_name) < 5) {
   $error = true;
   $userNameError = "Category must have atleat 5 characters.";
  }
     
    // if no error occured, continue ....
  if(!isset($errMSG))
  {
   $stmt = $DB_con->prepare('INSERT INTO category(cat_name) VALUES(:ucat_name)');
      
      $stmt->bindParam(':ucat_name',$cat_name);
      
   
      if($stmt->execute())
      {
        $successMSG = "new record succesfully inserted ...";
        header("refresh:3;tbl_category.php"); // redirects image view page after 5 seconds.
      }
      else
      {
        $errMSG = "error while inserting....";
      }
    }
 }
?>