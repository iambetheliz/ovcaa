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
  
  if(isset($_GET['document']) && !empty($_GET['document']))
  {
    $id = $_GET['document'];
    $stmt = $DB_con->prepare('SELECT * FROM material JOIN 
    category ON category.category_id = material.category_id WHERE filename =:id');
    $stmt->execute(array(':id'=>$id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
  }

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
<title>UPOU Scribd</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../assets/css/dashboard.css" rel="stylesheet" type="text/css">
<link href="../assets/css/simple-sidebar.css" rel="stylesheet" type="text/css">
<link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet" media="screen">
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
        <div class="container-fluid">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

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
            <!-- End of Brand and toggle -->

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
                            <li class="active">
                                <a href="tbl_materials"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp; Materials</a>
                            </li>
                            <?php 
                                if ($userData['role'] === 'admin') {?>
                            <li>
                                <a href="tbl_users"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp; Users</a>
                            </li>
                            <?php    }
                            ?>
                        </ul>
                    </li>
                </ul>
        </div>

      <!-- Main Screen -->
      <div class="container-fluid">
      
      <div class="row">
        <div class="col-sm-3">
          <h2 class="page-header"><strong><?php echo $row['title']; ?></strong></h2>
          <p>Uploaded by <span class="text-success"><strong><?php echo ucwords($row['uploaded_by']); ?></strong></span> on <?php echo date("F j, Y", strtotime($row["date_updated"])); ?></p><hr>
          <p><a href="edit_file.php?edit_id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-edit"></span> Edit document</a></p><hr>
          <p><strong>Description: </strong><?php echo $row['description'] ?></p>
        </div>
    
        <div class="col-lg-9 offset-lg-0">
        <!-- Page Content --><br><br>
            <!-- Iframe -->
            <div class="embed-responsive embed-responsive-4by3">
              <iframe class="embed-responsive-item" src="<?php echo $row['url']; ?>"></iframe>
            </div><br>
            <!-- End of Iframe -->
        </div>
        <!-- End of Content --> 
      </div><!-- /row -->

      </div><!-- /container-fluid -->

</div><!-- /container-fluid -->
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