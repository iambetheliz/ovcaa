<?php
    ob_start();
    session_start();
    require_once '../includes/dbconnect.php';
    
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
        
      if($stmt->execute()){
        ?>
                <script>
        alert('Successfully Updated ...');
        window.location.href='tbl_materials.php';
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
                        <h1 class="page-header">Edit</h1>
                    </div>
                </div>
                <!-- /.row -->

<br>          
 <form method="post" enctype="multipart/form-data">

<?php
  if(isset($errMSG)){
      ?>
            <div class="alert alert-danger">
              <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
  }
  else if(isset($successMSG)){
    ?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
  }
  ?>   

 <div class="form-group row"> 
    <label class="col-sm-2 col-form-label">Title: (Required)</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" >
        <small class="form-text text-muted">Title of your document.</small>
      </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Description: (Required)</label>
    <div class="col-sm-4">
    <textarea class="form-control" name="description" id="exampleTextarea" rows="3"><?php echo $description; ?></textarea>
    <small class="form-text text-muted">Description of your document.</small>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Category: (Required)</label>
    <div class="col-sm-4">
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
        ?>  <option value="Uncategorized">Select</option>
            <?php while($row1 = mysqli_fetch_array($result1)):;?>
            <option id="output" value="<?php echo $row1[0];?>"><?php echo $row1[1];?></option>
            <?php endwhile;?>
            <option value="new">Add new category</option>
        </select>
    </div>
  </div>

  <div class="form-group" id="newCat" style="display:none;">
  <label class="col-sm-2 col-form-label"></label>
        <div class="col-sm-4 form-group" id="cname">
                <input type="text" class="form-control" name="cat_name" placeholder="Specify category" autofocus />
        </div>
        <div class="form-inline">
            <button type="submit" id="add" name="add_new_cat" class="btn btn-primary">ADD</button>
      <script type="text/javascript">
        $('#cat_name').on('change',function(){
            if( $(this).val()==="new"){
              $("#newCat").show()
            }
            else{
              $("#newCat").hide()
            }
        });
      </script>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Old File:</label>    
    <div class="col-sm-4">
    <input disabled="" readonly="" type="text" class="form-control" name="file" value="<?php echo $edit_row['filename'] ?>" >
    </div>
  </div>  

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">New File: </label>
      <div class="col-sm-4">
        <input type="file" name="file" class="form-control-file" />
      </div>
  </div>
  
  <div class="form-group row">
  <label class="col-sm-2 col-form-label"></label>
    <div class="col-sm-4">
  <button type="submit" name="btn_save_updates" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span>
  &nbsp;&nbsp;UPDATE (<?php echo ini_get('upload_max_filesize').'B'; ?>) Max.</button>
  </div>
  </div>

  <textarea hidden="" name="uploaded_by"><?php echo $userRow['first_name']." ".$userRow['last_name'] ?></textarea>
  <textarea hidden="" name="location"><?php echo $location; ?></textarea>
  <textarea hidden="" name="url"><?php echo $url; ?></textarea>

  </form>
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

</body>
</html>
<?php ob_end_flush(); ?>