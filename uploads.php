<?php
include('User.php'); // Includes Login Script
include('Material.php');

session_start();

if(!isset($_SESSION['token'])){
header("location: 403-error.html");
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>UP Open University</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
 a[href="/absolute/path/to/index/root/parent/"] {display: none;}
</style>
</head>
<body>
<?php include('header.php'); ?>

<div class="wrap">
<div class="container">
<form action="" method="post">
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
                </div>
                    <div class="col-sm-1" right" style="right: 30px;"">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-sort"></span> Sort by <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="uploads.php?sorting='.$sort.'&field=title">Title</a></li>
                                <li><a href="uploads.php?sorting='.$sort.'&field=cat_name">Category</a></li>
                                <li><a href="uploads.php?sorting='.$sort.'&field=uploaded_by">Uploader</a></li>
                                <li><a href="uploads.php?sorting='.$sort.'&field=date_updated">Latest</a></li>
                            </ul>
                            <?php 
                                $field='title';
                                $sort='ASC';

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
                        <div class="input-group">
                            <div class="input-group-btn search-panel">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-filter"></span> Filter by <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#contains">Contains</a></li>
                                    <li><a href="#its_equal">It's equal</a></li>
                                    <li><a href="#greather_than">Greather than ></a></li>
                                    <li><a href="#less_than">Less than < </a></li>
                                    <li class="divider"></li>
                                    <li><a href="#all">Anything</a></li>
                                </ul>
                            </div>            
                            <input type="text" name="valueToSearch" class="form-control" placeholder="Search for terms..">
                            <span class="input-group-btn"><button class="btn btn-default" type="submit" name="search"><span class="glyphicon glyphicon-search"></span></button></span>
                        </div>
                    </div>
                </div><br>
                <!-- End of Buttons -->
 
 <!-- Table and Pagination -->
 <?php 
    include 'function.php';
    include 'pagination.php';
 ?>
  <!-- End of Table and Pagination -->
                
                <?php
                    if(isset($errMSG)){
                ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
                    </div>
                <?php
                }
                ?>
                </form>
            </div><!-- /.container-fluid -->
        </div><!-- /#page-wrapper -->
        <!-- End of Main Screen -->

    </div><!-- /#wrapper -->
</div><!-- /#wrap -->

    <footer class="footer">
    <div class="container-fluid">
        <p>&copy; UP Open University 2017</p>
    </div>
    </footer>

<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/index.js"></script>
    <script src='https://code.jquery.com/jquery-1.12.4.min.js'></script>
</body>
</html>