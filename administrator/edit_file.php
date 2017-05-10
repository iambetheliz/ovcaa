<?php

  include '../includes/dbconnect.php';
  include 'header.php';

  if(!isset($_SESSION['token'])){
    header("Location: index.php?loginError");
  }

  $DB_con = new mysqli("localhost", "root", "", "ovcaa");

  if ($DB_con->connect_errno) {
    echo "Connect failed: ", $DB_con->connect_error;
  exit();
  }

  require_once 'dbConnect.php';
  
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

  $error = false;  
  
  if(isset($_POST['btn_save_updates']))
  {
    $title = trim($_POST['title']);
    $title = strip_tags($title);
    $title = htmlspecialchars($title);
    $title = ucwords($title);

    $description = $_POST['description'];
    $description = ucfirst($description);

    $category_id = $_POST['category_id'];
    $cat_name = $_POST['cat_name'];
      
    $uploaded_by = $_POST['uploaded_by'];
    $uploaded_by = ucwords($uploaded_by);
    
    $file = $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];

    // new file size in KB
    $new_size = $file_size/1024;  
 
    // make file name in lower case
    $new_file_name = ucwords($file);
 
    $final_file=str_replace(' ','-',$new_file_name);
    
    if (empty($description)) {
        $description = 'No description';
      }

    // File error
      if ($final_file) {      
       $query = "SELECT filename FROM material WHERE filename='$final_file'";
       $result = $DB_con->query($query);

     if($result->num_rows != 0){
            $error = true;
            $errMSG = "<span class='glyphicon glyphicon-info-sign'></span> File already exists.";
        }
      }  
      
     // Title error         
      if (empty($title)) {
        $error = true;
        $TitleError = "Please enter a title.";
      } else if (strlen($title) < 5) {
        $error = true;
        $TitleError = "Title must have atleast 5 characters.";
      } 
      else if (!preg_match("/^[a-zA-Z ]+$/",$title)) {
        $error = true;
        $TitleError = "Title must contain only alphabets and space.";
      }   
      else {
        // check username exist or not
        $query = "SELECT title FROM material WHERE title='$title'";
        $result = $DB_con->query($query);

        if($result->num_rows != 0){
            $error = true;
            $TitleError = "Provided title is already in use.";
          }
      }
      // end Title error
          
    if($final_file)
    {
      $folder = 'uploads/'; // upload directory 
      $fileExt = strtolower(pathinfo($final_file,PATHINFO_EXTENSION)); 
        // valid image extensions
      $valid_extensions = array('docx', 'doc', 'pdf', 'xls', 'xlsx', 'ppt', 'pptx', 'csv', 'txt', 'jpg', 'jpeg', 'png'); // valid extensions

      // allow valid image file formats
        if(in_array($fileExt, $valid_extensions)){
          $url = "http" . ($_SERVER['HTTPS'] ? 's' : '') . "://{$_SERVER['HTTP_HOST']}".dirname($_SERVER['PHP_SELF'])."/{$folder}{$final_file}";
          $location = dirname($_SERVER['PHP_SELF'])."/{$folder}";

      unlink("../administrator/uploads/".$edit_row['filename']);
      move_uploaded_file($file_loc,$folder.$final_file);

            if($new_size > 5000000)    {     
                $error = true;
                $errMSG = "Sorry, your file is too large.";
            }
        } else{
          $error = true;
          $errMSG = "Sorry, only DOCX, PDF, XLS, CSV, TXT files and images are allowed.";  
        }
    }
    else
    {
      // if no image selected the old image remain as it is.
      $final_file = $edit_row['filename']; // old file from database
      $new_size = $edit_row['filesize'];// old file from database
    }             
    
    // if no error occured, continue ....
    if(!$error)
    {
      $stmt = $DB_con->prepare('UPDATE material SET title=:title, description=:description, filename=:filename, filesize=:new_size, location=:location, url=:url, uploaded_by=:uploaded_by, category_id=:category_id WHERE id=:id');
      $stmt->bindParam(':title',$title);
      $stmt->bindParam(':description',$description);
      $stmt->bindParam(':filename',$final_file);
      $stmt->bindParam(':new_size',$new_size);
      $stmt->bindParam(':location',$location);
      $stmt->bindParam(':url',$url);
      $stmt->bindParam(':uploaded_by',$uploaded_by);
      $stmt->bindParam(':category_id', $_POST['category_id']);
      $stmt->bindParam(':id',$id);

      move_uploaded_file($file_loc,$folder.$final_file);
        
      if($stmt->execute()){
        $successMSG = "Successfully updated...";
        header("refresh:3;tbl_materials.php");
      }
      else{
        $errMSG = "Sorry Data Could Not Updated !";
        header("refresh:3;tbl_materials.php");
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
                <?php
                    if(!empty($userData)){?>
                        <li><?php echo $account; ?></li>
                        <li><?php echo $logout; ?></li>
                <?php }?>
            </ul> 
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
                                  <a href="tbl_materials"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp; Materials</a>
                              </li>
                              <li>
                                  <a href="tbl_users"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp; Users</a>
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
                        <h3 class="page-header"><strong>Update:</strong> <?php echo $title; ?></h3>
                    </div>
                </div>
                <!-- /.row -->

<!-- Main Form -->
<form method="post" enctype="multipart/form-data" action="" >
<!-- Error/Success Messages -->
<div class="form-group">
<div class="col-sm"> 
  <?php
    if(isset($successMSG)){
      ?>
      <div class="alert alert-success"><?php echo $successMSG; ?></div>
  <?php
    }
    if(isset($errMSG)){
      ?>
      <div class="alert alert-danger"><?php echo $errMSG; ?></div>

  <?php
    }
  ?>
</div>
</div>
<!-- Error/Success Messages -->

<div class="row">
<div class="col-sm-6 col-md-5 col-lg-6">
  <div class="form-group row"> 
        <div class="col-sm-8">
          <strong>Title</strong> <sup class="text-danger">*</sup>
          <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" autofocus />
          <p class="text-danger"><?php echo $TitleError; ?></p>
        </div>
  </div>

  <div class="form-group row">
      <div class="col-sm-8">
          <strong>Description</strong> 
          <textarea class="form-control" name="description" id="exampleTextarea" rows="3"><?php echo $description; ?></textarea>   
          <p class="text-danger"><?php echo $descError; ?></p>
      </div>
  </div>

  <div class="form-group row" style="display: none;">
      <div class="col-sm-8">
          <input type="text" class="form-control" name="uploaded_by" value="<?php echo $userData['first_name']." ".$userData['last_name'] ?>" />
          <input type="text" class="form-control" name="location" value="<?php echo $location; ?>" />
          <input type="text" class="form-control" name="url" value="<?php echo $url; ?>" />
      </div>
  </div>
</div>

  <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
  <div class="form-group row">
    <div class="col-sm-8"> 
        <strong>Category</strong> <sup class="text-danger">*</sup>
        <?php
            // php select option value from database
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $databaseName = "ovcaa";

            // connect to mysql database
            $connect = mysqli_connect($hostname, $username, $password, $databaseName);

            // mysql select query
            $query = "SELECT * FROM `category` ORDER BY category_id";

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
        <script src="../assets/js/jquery.min.js"></script>
        <select name="category_id" class="form-control" id="cat_name">
        <?php
            if(isset($_POST['add_new_cat']) )
              {
                  $cat_name = $_POST['cat_name'];

                  $stmt = $DB_con->prepare('INSERT INTO category(cat_name) VALUES (:cat_name)');
                  $stmt->bindParam(':cat_name',$cat_name);

                  if($stmt->execute())
                      {
                        header('refresh:3;tbl_materials.php');
                      }
                  else
                      {
                        $errMSG = "Error!";
                        header('refresh:3;tbl_materials.php');
                      }
              }
        ?>  <?php while($row1 = mysqli_fetch_array($result1)):;?>
            <option id="output" value="<?php echo $row1[0];?>"><?php echo $row1[1];?></option>
            <?php endwhile;?>
       </select>
    </div>
  </div>
  
  <div class="form-group row">
    <div class="col-sm-8">
      <strong>Old File</strong> 
      <input disabled="" readonly="" type="text" class="form-control" name="file" value="<?php echo $edit_row['filename'] ?>" >
    </div>
  </div>  

  <div class="form-group row"> 
    <div class="col-sm-8">
      <strong>New</strong> 
      <div class="input-group">
      <span class="input-group-btn">
        <button id="file-button-browse" type="button" class="btn btn-default">
          <span class="glyphicon glyphicon-file"></span>  Browse
        </button>
      </span>
      <input type="file" class="form-control-file" name="file" id="files-input-upload" style="display:none">
      <input type="text" id="file-input-name" disabled="disabled" placeholder="File not selected" class="form-control">
    </div>
    <script type="text/javascript">
      document.getElementById('file-button-browse').addEventListener('click', function() {
      document.getElementById('files-input-upload').click();
      });
      document.getElementById('files-input-upload').addEventListener('change', function() {
      document.getElementById('file-input-name').value = this.value;
      });
    </script>
    </div>
  </div>
  <br>

  </div></div>
  
  <div class="form-group row">
      <div class="col-sm-6 col-md-5 col-lg-6">
          <a type="button" href="tbl_materials.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> CANCEL </a>&nbsp;
          <button type="submit" name="btn_save_updates" class="btn btn-success"><span class="glyphicon glyphicon-upload"></span>&nbsp;UPDATE
          </button>
      </div>
  </div>

  </div>
  </div>
  </form>

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

</body>
</html>
<?php ob_end_flush(); ?>