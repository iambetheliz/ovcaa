<?php
    ob_start();
    session_start();
    require_once 'includes/dbconnect.php';
    
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
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $cat_name = $_POST['cat_name'];
    $uploaded_by = $_POST['uploaded_by'];
  
    $file = $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];

    // new file size in KB
    $new_size = $file_size/1024;  
 
    // make file name in lower case
    $new_file_name = strtolower($file);
 
    $final_file=str_replace(' ','-',$new_file_name);
    
  if(empty($title)){
   $errMSG = "Please Enter Title.";
  }
  elseif (!empty($title)) {
    $query = "SELECT title FROM material WHERE title='$title'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $errMSG = "Provided title is already in use.";
   }
  }
  else if(empty($description)){
   $errMSG = "Please Enter Description.";
  }
  else if(empty($final_file)){
   $errMSG = "Please Select FIle.";
  }
  else
  {
   $folder = 'uploads/'; // upload directory 

   $fileExt = strtolower(pathinfo($final_file,PATHINFO_EXTENSION)); // get image extension

   // valid image extensions
   $valid_extensions = array('exe', 'zip', 'rar'); // valid extensions
     
   // allow valid image file formats
   if(!in_array($fileExt, $valid_extensions)){  
   // Check file size '5MB'
    if($new_size < 5000000)    {     
      $url = "http" . ($_SERVER['HTTPS'] ? 's' : '') . "://{$_SERVER['HTTP_HOST']}".dirname($_SERVER['PHP_SELF'])."/{$folder}{$final_file}";
      $location = dirname($_SERVER['PHP_SELF'])."/{$folder}";
     move_uploaded_file($file_loc,$folder.$final_file);
    }
    else{
     $errMSG = "Sorry, your file is too large.";
    }
  }  
  else{
    $errMSG = "Sorry, only DOCX, PDF, XLS, CSV, TXT files and images are allowed.";  
   }
}
  
  // if no error occured, continue ....
  if(!isset($errMSG))
  {
   $stmt = $DB_con->prepare('INSERT INTO material(title,description,filename,filesize,location,url,uploaded_by,category_id) VALUES(:title, :description, :filename, :new_size, :location, :url, :uploaded_by, :category_id); INSERT INTO category(cat_name) VALUES (:cat_name)');
      $stmt->bindParam(':title',$title);
      $stmt->bindParam(':cat_name',$cat_name);
      $stmt->bindParam(':description',$description);
      $stmt->bindParam(':filename',$final_file);
      $stmt->bindParam(':new_size',$new_size);
      $stmt->bindParam(':location',$location);
      $stmt->bindParam(':url',$url);
      $stmt->bindParam(':uploaded_by',$uploaded_by);
      $stmt->bindParam(':category_id', $_POST['category_id']);
   
      if($stmt->execute())
      {
        $successMSG = "new record succesfully inserted ...";
        header("refresh:3;tbl_materials.php"); // redirects image view page after 5 seconds.
      }
      else
      {
        $errMSG = "error while inserting....";
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
  if ( isset($errMSG)) {
?>
        <div class="modal-header alert alert-danger">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> ERROR!</h4>
        </div>
        <div class="modal-body">
          
  <div class="form-group">
          <p class="text-danger"><?php echo $errMSG; ?></p>
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
      <p class="text-success"><?php echo $successMSG; ?></p>
  </div>
<?php
 }
?> 
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" data-toggle="modal" data-dismiss="modal" data-target="#myModalNorm">GO BACK</button>
          <a class="btn btn-default" role="button" aria-pressed="true" href="tbl_materials.php" >Ok</a>
        </div>
      </div>

    </div>
</div>
<?php include 'tbl_materials.php';?>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
</body>

</html>