<?php

  include '../includes/pagination.php'; 
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
    
    if(isset($_GET['delete_id']))
 {
  // select image from db to delete
  $stmt_select = $DB_con->prepare('SELECT * FROM users WHERE uid =:id');
  $stmt_select->execute(array(':id'=>$_GET['delete_id']));
  $fileRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
  
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM users WHERE uid =:id');
  $stmt_delete->bindParam(':id',$_GET['delete_id']);
  $stmt_delete->execute();
  
  header("Location: tbl_users.php");
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
<title>Table: Users - UP Open University</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../assets/css/simple-sidebar.css" rel="stylesheet" type="text/css">
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
                <a class="navbar-brand" href="#menu-toggle" id="menu-toggle" title="Toggle Sidebar"><span class="glyphicon glyphicon-align-justify"></span></a>
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
            <!-- End of Top Menu Items -->
            
        </div>
        </nav>
        <!-- /.navbar-collapse -->

        <!-- Sidebar Menu Items -->
        <br><br>
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav"> 
                <li>
                    <a href="/ovcaa/administrator"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp; Dashboard</a>
                </li>
                <li  class="active">
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp; Tables &nbsp;&nbsp;<span class="caret"></span></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="tbl_materials"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp; Materials</a>
                            </li>
                            <li class="active">
                                <a href="tbl_users"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp; Users</a>
                            </li>
                        </ul>
                </li>
            </ul>
        </div>

        <!-- Main Screen -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                
                <?php    
                $stmt = $DB_con->prepare('SELECT * FROM users ORDER BY uid');
                $stmt->execute();    
                $count = $stmt->rowCount();
                ?>
                
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <strong><a style="color: black;text-decoration: none;" href="tbl_users.php">Users</a> <font color="#7b1113">(<?php echo $count; ?>)</font></strong>
                        </h1>
                    </div>
                </div>
                <!-- End of Page Heading -->

                <!-- Buttons -->
                <div class="row">
                    <div class="col col-xs-7">
                        <a href="add_user.php" class="btn btn-success" type="button" role="button" >
                            <span class="glyphicon glyphicon-plus"></span> Add New
                        </a>  
                        <label for="submit-form" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Delete Multiple</label>
                    </div>
                    <div class="col col-xs-2 text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-sort"></span> Sort by <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="tbl_users.php?sorting='.$sort.'&field='.$field.'">Default</a></li>
                                <li><a href="tbl_users.php?sorting='.$sort.'&field=first_name">Name</a></li>
                                <li><a href="tbl_users.php?sorting='.$sort.'&field=email">Email</a></li>
                                <li><a href="tbl_users.php?sorting='.$sort.'&field=created">Date Added</a></li>
                            </ul>
                            <?php 
                                $field='role';
                                $sort='ASC';

                                if(isset($_GET['sorting']))
                                    {
                                        if($_GET['sorting']=='ASC')
                                            {
                                                $sort='DESC';
                                            }
                                        else { $sort='ASC'; }
                                    }
                                if($_GET['field']=='first_name')
                                    { 
                                        $field = "first_name";  
                                    }
                                elseif($_GET['field']=='email')
                                    {
                                        $field = "email"; 
                                    }
                                elseif($_GET['field']=='created')
                                    { 
                                        $field="created"; 
                                        $sort="DESC";
                                    }
                            ?>
                        </div>
                    </div>
                    <div class="col col-xs-3 text-right">
                    <form action="" method="get">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search for terms..">
                            <span class="input-group-btn"><button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button></span>
                        </div>       
                    </form>
                    </div>
                </div>
                <!-- End of Buttons -->

                <br>
                <!-- Table and Pagination -->  
                <form id="myForm" name="bulk_action_form" action="action.php" method="post" onSubmit="return delete_confirm();"/>
                <?php 
                    include 'users.php';
                ?>
                <input type="submit" class="btn btn-danger hidden" id="submit-form" name="bulk_delete_user" value="Delete"/>
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

    <!-- Menu Toggle Script -->
    <script>
    $( document ).ready(function() {
        $("#wrapper").addClass("toggled");
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    });
    </script>

</body>
</html>