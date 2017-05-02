<?php
    session_start();
    require_once '../includes/dbconnect.php';

    $DB_con = new mysqli("localhost", "root", "", "ovcaa");

    if ($DB_con->connect_errno) {
      echo "Connect failed: ", $DB_con->connect_error;
    exit();
    }
   
    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
      header("Location: /ovcaa/administrator");
    exit;
    }

    // select loggedin members detail
    $res = "SELECT * FROM members WHERE userId=".$_SESSION['user'];
    $result = $DB_con->query($res);

    if ($result->num_rows != 0) {
      $userRow = $result->fetch_array(MYSQLI_BOTH);
    }

    require_once 'dbConnect.php';
    
    if(isset($_GET['delete_id']))
 {
  // select image from db to delete
  $stmt_select = $DB_con->prepare('SELECT * FROM members WHERE userId =:id');
  $stmt_select->execute(array(':id'=>$_GET['delete_id']));
  $fileRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
  
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM members WHERE userId =:id');
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $userRow['userName'] ; ?>&nbsp;&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="view_profile.php" title="Update Profile" >Profile Settings</a></li>                       
                        <li><a href="logout.php?logout">Logout</a></li>
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

            </div>
            </nav><!-- /.navbar-collapse -->

        <br><br>
        <!-- Main Screen -->
        <div id="page-wrapper">
            <div class="container-fluid">
                
                <?php    
                $stmt = $DB_con->prepare('SELECT * FROM members ORDER BY userId');
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
                    <div class="col col-xs-4">
                        <a href="add_user.php" class="btn btn-success" type="button" role="button" >
                            <span class="glyphicon glyphicon-plus"></span> Add New
                        </a>  
                    </div>                            
                    <div class="col col-xs-3"></div>         
                    <div class="col col-xs-2 text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-sort"></span> Sort by <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="tbl_users.php?sorting='.$sort.'&field=userName">Username</a></li>
                                <li><a href="tbl_users.php?sorting='.$sort.'&field=userEmail">Email</a></li>
                                <li><a href="tbl_users.php?sorting='.$sort.'&field=regDate">Date Added</a></li>
                            </ul>
                            <?php 
                                $field='regDate';
                                $sort='DESC';

                                if(isset($_GET['sorting']))
                                    {
                                        if($_GET['sorting']=='ASC')
                                            {
                                                $sort='DESC';
                                            }
                                        else { $sort='ASC'; }
                                    }
                                if($_GET['field']=='userName')
                                    { 
                                        $field = "userName";  
                                    }
                                elseif($_GET['field']=='userEmail')
                                    {
                                        $field = "userEmail"; 
                                    }
                                elseif($_GET['field']=='regDate')
                                    { 
                                        $field="regDate"; 
                                        $sort="DESC";
                                    }
                            ?>
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
                <!-- Table and Pagination -->
                <?php 
                    include '../includes/pagination.php';
                    include 'users.php';
                ?>                               
                </form>

            </div><!-- /.container-fluid -->
        </div><!-- /#page-wrapper -->
        <!-- End of Main Screen -->

    </div><!-- /#wrapper -->
</div><!-- /#wrap -->

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