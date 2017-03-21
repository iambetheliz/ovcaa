<?php
include('session.php'); // Includes Login Script

session_start();
?>
<?php

  error_reporting( ~E_NOTICE );
  
  require_once 'Material.php';
  
  if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
  {
    $id = $_GET['edit_id'];
    $stmt_edit = $DB_con->prepare('SELECT * FROM material JOIN 
    category ON category.category_id = material.category_id WHERE id =:id');
    $stmt_edit->execute(array(':id'=>$id));
    $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($edit_row);
  }
  else
  {
    header("Location: tbl_materials.php");
  }  
  
  
  if(isset($_POST['btn_save_updates']))
  {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $cat_name = $_POST['cat_name'];
    $uploaded_by = $_POST['uploaded_by'];
    $date = date('Y-m-d H:i:s');
  
    $file = $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];

    // new file size in KB
    $new_size = $file_size/1024;  
    // new file size in KB
 
    // make file name in lower case
    $new_file_name = strtolower($file);
    // make file name in lower case
 
    $final_file=str_replace(' ','-',$new_file_name);
          
    if($final_file)
    {
      $folder = 'uploads/'; // upload directory 

      if($new_size < 5000000)
        {
          $url = "http" . ($_SERVER['HTTPS'] ? 's' : '') . "://{$_SERVER['HTTP_HOST']}".dirname($_SERVER['PHP_SELF'])."/{$folder}{$final_file}";
      $location = dirname($_SERVER['PHP_SELF'])."/{$folder}";
          unlink($folder.$edit_row['filename']);
          move_uploaded_file($file_loc,$folder.$final_file);
        }
        else
        {
          $errMSG = "Sorry, your file is too large it should be less then 5MB";
        }
    }
    else
    {
      // if no image selected the old image remain as it is.
      $final_file = $edit_row['filename']; // old file from database
      $new_size = $edit_row['filesize'];// old file from database
    } 
            
    
    // if no error occured, continue ....
    if(!isset($errMSG))
    {
      $stmt = $DB_con->prepare('UPDATE material SET title=:title, description=:description, filename=:filename, filesize=:new_size, location=:location, url=:url, uploaded_by=:uploaded_by, date_updated=:date_updated, category_id=:category_id WHERE id=:id');
      $stmt->bindParam(':title',$title);
      $stmt->bindParam(':description',$description);
      $stmt->bindParam(':filename',$final_file);
      $stmt->bindParam(':new_size',$new_size);
      $stmt->bindParam(':location',$location);
      $stmt->bindParam(':url',$url);
      $stmt->bindParam(':uploaded_by',$uploaded_by);
      $stmt->bindParam(':date_updated',$date);
      $stmt->bindParam(':category_id', $_POST['category_id']);
      $stmt->bindParam(':id',$id);
        
      if($stmt->execute()){
        ?>
                <script>
        alert('Successfully Updated ...');
        window.location.href='uploads.php';
        </script>
                <?php
      }
      else{
        $errMSG = "Sorry Data Could Not Updated !";
      }
    
    }
    
            
  }
  
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>UP Open University</title>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/bootstrap-theme.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<?php include('header.php'); ?>
<div class="wrap">
        <div class="container">
                <div class="site-index"><br><br>
                <div class="jumbotron">
    <?php
  if(isset($errMSG)){
      ?>
            <div class="alert alert-danger">
              <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div><br>
            <?php
  }
  else if(isset($successMSG)){
    ?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div><br>
        <?php
  }
  ?>   
 <form method="post" enctype="multipart/form-data">

 <div class="form-group row"> 
    <label class="col-sm-2 col-form-label">Title: (Required)</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" >
    <small id="emailHelp" class="form-text text-muted">Title of your document.</small>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Description: (Required)</label>
    <div class="col-sm-10">
    <textarea class="form-control" name="description" id="exampleTextarea" rows="3"><?php echo $description; ?></textarea>
    <small id="emailHelp" class="form-text text-muted">Description of your document.</small>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Category: (Required)</label>
    <div class="col-sm-10">
        <?php
            // php select option value from database
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $databaseName = "ovcaa";

            // connect to mysql database
            $connect = mysqli_connect($hostname, $username, $password, $databaseName);

            // mysql select query
            $query = "SELECT * FROM `category`";

            // for method 1
            $result1 = mysqli_query($connect, $query);

            // for method 2
            $result2 = mysqli_query($connect, $query);

            $options = "";

            while($row2 = mysqli_fetch_array($result2))
                  {
                      $options = $options."<option>$row2[1]</option>";
                  }
        ?>
        <select name="category_id" class="form-control" id="exampleSelect1">
            <option>(old) <?php echo $cat_name;?></option>
            <?php while($row1 = mysqli_fetch_array($result1)):;?>
            <option value="<?php echo $row1[0];?>"><?php echo $row1[1];?></option>
            <?php endwhile;?>
        </select>
    <small id="emailHelp" class="form-text text-muted">Title of your document.</small>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Old File:</label>    
    <div class="col-sm-10">
    <input disabled="" readonly="" type="text" class="form-control" name="file" value="<?php echo $edit_row['filename'] ?>" >
    </div>
  </div>  

  <div class="form-group row">
  <label class="col-sm-2 col-form-label">New File: </label>
    <div class="col-sm-10">
    <input type="file" name="file" class="form-control-file" />
  </div>
  </div>
  
  <div class="form-group row">
  <label class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
  <button type="submit" name="btn_save_updates" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span>
  &nbsp;&nbsp;UPDATE (<?php echo ini_get('upload_max_filesize').'B'; ?>) Max.</button>
  </div>
  </div>

  <textarea hidden="" name="uploaded_by"><?php echo "$uploader";?></textarea>
  <textarea hidden="" name="location"><?php echo $location; ?></textarea>
  <textarea hidden="" name="url"><?php echo $url; ?></textarea>

  </form>
 
</div>
</div>
</div>
</div>

<footer class="footer">
<div class="container">
        <p>&copy; UP Open University 2017</p>
</div>
</footer>

<script src="../assets/js/bootstrap.js"></script>
</body>
</html>