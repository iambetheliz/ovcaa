<?php

  include 'header.php';

  if(!isset($_SESSION['token'])){
    header("Location: index.php?loginError");
  }
  
  require_once '../includes/dbconnect.php';

  $DB_con = new mysqli("localhost", "root", "", "ovcaa");

  if ($DB_con->connect_errno) {
    echo "Connect failed: ", $DB_con->connect_error;
  exit();
  }

    require_once 'dbConnect.php';
    
    if(isset($_GET['delete_id'])) {

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
<title>Table: Material - UP Open University</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<style type="text/css">
/* For pagination function. */
ul.pagination>li>a {
    color:#014421;
}
ul.pagination>li>a.current {
    background:#014421;
    color:#fff;
}
</style>
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
                    <li  class="active">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp; Tables &nbsp;&nbsp;<span class="caret"></span></a>
                        <ul id="demo" class="collapse">
                            <li class="active">
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
                        <h1 class="page-header"><strong><a style="color: black;text-decoration: none;" href="tbl_materials.php">Uploads</a> <font color="#7b1113">(<?php echo $count; ?>)</font></strong></h1>
                    </div>
                </div>
                <!-- End of Page Heading -->

                <!-- Buttons -->
                <div class="row">
                    <div class="col col-xs-4">
                        <a href="upload-document.php" class="btn btn-success" type="button" role="button" >
                            <span class="glyphicon glyphicon-plus"></span> Upload New File
                        </a>  
                    </div>  
                    <div class="col col-xs-3"></div>
                    <div class="col col-xs-2 text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-sort"></span> Sort by <span class="caret"></span>
                            </button>
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
                                if(isset($_GET['field']))
                                    {
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
                                    }
                            ?>
                            <ul class="dropdown-menu">
                                <li><a href="tbl_materials.php">Default</a></li>
                                <li><a href="tbl_materials.php?sorting='.$sort.'&field=title">Title</a></li>
                                <li><a href="tbl_materials.php?sorting='.$sort.'&field=cat_name">Category</a></li>
                                <li><a href="tbl_materials.php?sorting='.$sort.'&field=uploaded_by">Uploader</a></li>
                                <li><a href="tbl_materials.php?sorting='.$sort.'&field=date_updated">Latest</a></li>
                            </ul>
                        </div>
                    </div>
                    <form action="" method="get">
                    <div class="col col-xs-3 text-right">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search for terms..">
                            <span class="input-group-btn"><button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button></span>
                        </div>
                    </div>
                </div>
                <!-- End of Buttons -->
                <br>
                <div class="container-fluid">
                <?php 
                    include '../includes/pagination.php'; 
                    include 'files.php'; 
                ?>
                </div>
                <br>
                    </form>

            </div><!-- /.container-fluid -->
        </div><!-- /#page-wrapper -->
        <!-- End of Main Screen -->

    </div><!-- /#wrapper -->
</div><!-- /#wrap -->

<footer>
    <div class="container-fluid">
        <p align="right"><a href="/ovcaa/" target="_blank">UP Open University - Scribd</a> &copy; <?php echo date("Y"); ?></p>
    </div>
</footer>

<!-- jQuery -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>

</body>
</html>
