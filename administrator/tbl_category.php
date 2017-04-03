<?php
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

    require_once 'Material.php';
    
    if(isset($_GET['delete_id']))
 {
  // select image from db to delete
  $stmt_select = $DB_con->prepare('SELECT * FROM category WHERE category_id =:id');
  $stmt_select->execute(array(':id'=>$_GET['delete_id']));
  $fileRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
  unlink("../administrator/uploads/".$fileRow['filename']);
  
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM category WHERE category_id =:id');
  $stmt_delete->bindParam(':id',$_GET['delete_id']);
  $stmt_delete->execute();
  
  header("Location: tbl_category.php");
 }

 if(isset($_POST['bulk_delete_submit'])){
        $idArr = $_POST['checked_id'];
        foreach($idArr as $id){
            mysqli_query($conn,"DELETE FROM category WHERE category_id=".$id);
        }
        $successMSG = 'Users have been deleted successfully.';
        header("Location:tbl_category.php");
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
<title>Table: Material - UP Open University</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/custom.css" rel="stylesheet">
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $userRow['userName'] ?>&nbsp;&nbsp;<span class="caret"></span></a>
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
        <!-- End of Navigation -->

        <br><br>
        <!-- Main Screen -->
        <div id="page-wrapper">
            <div class="container-fluid">
                
                <?php    
                $stmt = $DB_con->prepare('SELECT * FROM category ORDER BY category_id DESC');
                $stmt->execute();    
                $count = $stmt->rowCount();
                ?>

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><strong><a style="color: black;text-decoration: none;" href="tbl_category.php">Category</a> <font color="#7b1113">(<?php echo $count; ?>)</font></strong></h1>
                    </div>
                </div>
                <!-- End of Page Heading -->

                <!-- Buttons -->
                <div class="row">
                    <div class="col-sm-7">

<?php  include 'refresh_addcat.php';   ?>

<form method="post" enctype="multipart/form-data" action="" autocomplete="off">

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

  <div class="form-group row">
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
 </div>
 </form>  

  <div class="col-sm-1"  style="right: 30px;" hidden="">
                        <div class="input-group-btn" hidden="">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" hidden="">
                                <span class="glyphicon glyphicon-sort"></span> Sort by <span class="caret" hidden="" hidden=""></span>
                            </button>
                            <ul class="dropdown-menu" hidden="">
                                <li><a href="tbl_category.php" hidden="">Default</a></li>                                
                                <li><a href="tbl_category.php?sorting='.$sort.'&field=cat_name" hidden="">Category</a></li>
                            </ul>
                            <?php 
                                $field='cat_name';
                                $sort='DESC';

                                if(isset($_GET['sorting']))
                                    {
                                        if($_GET['sorting']=='ASC')
                                            {
                                                $sort='DESC';
                                            }
                                        else { $sort='ASC'; }
                                    }                                
                                elseif($_GET['field']=='cat_name')
                                    {
                                        $field = "cat_name"; 
                                    }
                            ?>
                        </div>
                    </div>
                 
                    <div class="col-sm-4 right">
                <form action="" method="get">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search for terms..">
                            <span class="input-group-btn"><button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button></span>
                        </div>
                    </div>
                </div><br>
                <!-- End of Buttons -->
                
                <!-- Table and Pagination -->
                <?php 
                    include '../includes/pagination.php';
                    include 'category.php';     
                    include 'add_category.php';               
                ?>
                <!-- End of Table and Pagination -->
                </form>
            </div><!-- /.container-fluid -->
        </div><!-- /#page-wrapper -->
        <!-- End of Main Screen -->

    </div><!-- /#wrapper -->
</div><!-- /#wrap -->
<br>
    <footer class="footer">
        <div class="container-fluid">
            <p align="right">UP Open University - Scribd &copy; <?php echo date("Y"); ?></p>
        </div>
    </footer>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
</body>
</html>
