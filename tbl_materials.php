<?php
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

    require_once 'Material.php';
    
    if(isset($_GET['delete_id']))
 {
  // select image from db to delete
  $stmt_select = $DB_con->prepare('SELECT material.filename, category.category_id, category.cat_name FROM material JOIN 
    category ON category.category_id = material.category_id WHERE id =:id');
  $stmt_select->execute(array(':id'=>$_GET['delete_id']));
  $fileRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
  unlink("../administrator/uploads/".$fileRow['filename']);
  
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM material WHERE id =:id');
  $stmt_delete->bindParam(':id',$_GET['delete_id']);
  $stmt_delete->execute();
  
  header("Location: tbl_materials.php");
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $userRow['userEmail']; ?>&nbsp;&nbsp;<span class="caret"></span></a>
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
                    <li  class="active">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp; Tables &nbsp;&nbsp;<span class="caret"></span></a>
                        <ul id="demo" class="collapse">
                            <li class="active">
                                <a href="tbl_materials.php"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp; Files</a>
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
        <!-- End of Navigation -->

        <br><br>
        <!-- Main Screen -->
        <div id="page-wrapper">
            <div class="container-fluid">
                
                <?php    
                $stmt = $DB_con->prepare('SELECT *, category.category_id, category.cat_name FROM material JOIN 
                category ON category.category_id = material.category_id ORDER BY date_created DESC');
                $stmt->execute();    
                $count = $stmt->rowCount();
                ?>

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><strong>Uploads <font color="#7b1113">(<?php echo $count; ?>)</font></strong></h1>
                    </div>
                </div>
                <!-- End of Page Heading -->

                <!-- Buttons -->
                <div class="row">
                    <div class="col-sm-7">
                        <!-- Button trigger modal -->
                        <button class="btn btn-success" data-toggle="modal" data-target="#myModalNorm">
                            <span class="glyphicon glyphicon-plus"></span> Upload New File
                        </button>
                        <!-- Modal -->
<div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Uploading New File <small>(<?php echo ini_get('upload_max_filesize').'B'; ?>) Max.</small></h4> 
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form method="post" enctype="multipart/form-data" action="upload-document.php" autocomplete="off">
    
    <div class="form-group row">
    <div class="col-sm-4">
    <input type="file" name="file" class="form-control-file" />
  </div>
  </div>

    <div class="form-group">
    <label>Title: (Required)</label>
    <input type="text" class="form-control" name="title" value="<?php echo $filename; ?>">
    <small class="form-text text-muted">This is the title of your document.</small>
  </div>

        <div class="form-group">
    <label>Description: (Required)</label>
    <textarea class="form-control" name="description" rows="3"><?php echo $description; ?></textarea>
    <small class="form-text text-muted">This is the description of your document.</small>
  </div>

  <div class="form-group row">
    <label class="col-sm-4 col-form-label">Category: (Required)</label>
    <div class="col-sm-8">
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
                        header("Refresh:3; url=tbl_materials.php"); // redirects image view page after 5 seconds.
                      }
                  else
                      {
                        $errMSG = "error while inserting....";
                      }
              }
        ?>  <option>Select</option>
            <?php while($row1 = mysqli_fetch_array($result1)):;?>
            <option value="<?php echo $row1[0];?>"><?php echo $row1[1];?></option>
            <?php endwhile;?>
            <option value="new">Add new category</option>
        </select>
    </div>
  </div>

  <div class="form-group" id="newCat" style="display:none;">
  <label class="col-sm-4 col-form-label"></label>
        <div class="col-sm-4 form-group">
                <input type="text" class="form-control" id="category" name="cat_name" placeholder="Specify category"/>
        </div>
        <div class="form-inline">
            <button type="submit" name="add_new_cat" class="btn btn-primary">ADD</button>
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

 <textarea hidden="" name="uploaded_by"><?php echo $userRow['userName']; ?></textarea>
 <textarea hidden="" name="location"><?php echo $location; ?></textarea>
 <textarea hidden="" name="url"><?php echo $url; ?></textarea>                
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel </button>
                <button type="submit" name="btn-upload" class="btn btn-primary"><span class="glyphicon glyphicon-upload"></span> UPLOAD </button> 
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->
                </div>
                    <div class="col-sm-1" right" style="right: 30px;"">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-sort"></span> Sort by <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="tbl_materials.php">Default</a></li>
                                <li><a href="tbl_materials.php?sorting='.$sort.'&field=title">Title</a></li>
                                <li><a href="tbl_materials.php?sorting='.$sort.'&field=cat_name">Category</a></li>
                                <li><a href="tbl_materials.php?sorting='.$sort.'&field=uploaded_by">Uploader</a></li>
                                <li><a href="tbl_materials.php?sorting='.$sort.'&field=date_updated">Latest</a></li>
                            </ul>
                            <?php 
                                $field='date_updated';
                                $sort='DESC';

                                if(isset($_GET['sorting']))
                                    {
                                        if($_GET['sorting']=='ASC')
                                            {
                                                $sort='DESC';
                                            }
                                        else { $sort='ASC'; }
                                    }
                                if($_GET['field']=='title')
                                    { 
                                        $field = "title";  
                                    }
                                elseif($_GET['field']=='cat_name')
                                    {
                                        $field = "cat_name"; 
                                    }
                                elseif($_GET['field']=='uploaded_by')
                                    { 
                                        $field="uploaded_by"; 
                                    }
                                elseif($_GET['field']=='date_updated')
                                    { 
                                        $field="date_updated"; 
                                        $sort="DESC";
                                    }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4 right">
                <form action="tbl_materials.php" method="get">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search for terms..">
                            <span class="input-group-btn"><button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button></span>
                        </div>
                    </div>
                </div><br>
                <!-- End of Buttons -->
                
                <!-- Table and Pagination -->
                <?php 
                    include 'function.php';
                    include 'files.php';
                ?>
                <!-- End of Table and Pagination -->
                </form>
            </div><!-- /.container-fluid -->
        </div><!-- /#page-wrapper -->
        <!-- End of Main Screen -->

    </div><!-- /#wrapper -->
</div><!-- /#wrap -->

    <footer class="footer">
        <div class="container-fluid">
            <p align="right">&copy; UP Open University 2017 <a class="top-nav" href="/ovcaa">View Site</a></p>
        </div>
    </footer>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
</body>

</html>
