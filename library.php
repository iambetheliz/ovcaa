<?php
include('User.php'); // Includes Login Script
include('dbConnect.php');
include_once ('gpConfig.php');

if(!isset($_SESSION['token'])){
header("Location: index.php?loginError");
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>UP Open University</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
<?php include('header.php'); ?>

<!-- Main Screen -->
<div class="wrap">
    <div class="container">

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
                    <div class="col col-xs-4"></div>
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
                                <li><a href="library.php?sorting='.$sort.'&field=title">Title</a></li>
                                <li><a href="library.php?sorting='.$sort.'&field=cat_name">Category</a></li>
                                <li><a href="library.php?sorting='.$sort.'&field=uploaded_by">Uploader</a></li>
                                <li><a href="library.php?sorting='.$sort.'&field=date_updated">Latest</a></li>
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
                </div><br>
                <!-- End of Buttons -->
 
 <!-- Table and Pagination -->
 <div class="container-fluid">
 <?php 
    include 'includes/pagination.php';
    include 'files.php';
 ?>
 </div>
<!-- End of Table and Pagination -->

    </div><!-- /#wrapper -->
</div><!-- /#wrap -->

    <footer class="footer">
    <div class="container-fluid">
        <p align="right">UP Open University - Scribd &copy; <?php echo date("Y"); ?></p>
    </div>
    </footer>

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/index.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</body>
</html>