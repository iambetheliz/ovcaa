<?php
session_start();
include 'dbConnect.php';
include 'header.php';
include '../includes/Class.NumbersToWords.php';

if(!isset($_SESSION['token'])){
header("Location: index.php?loginError");
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
<title>Admin - UPOU Scribd</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../assets/css/dashboard.css" rel="stylesheet" type="text/css">
<link href="../assets/css/simple-sidebar.css" rel="stylesheet" type="text/css">
<link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet" media="screen">
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
                <li class="active">
                    <a href="/ovcaa/administrator"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp; Dashboard</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp; Tables &nbsp;&nbsp;<span class="caret"></span></a>
                    <ul id="demo" class="collapse">
                        <li>
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
        <div id="page-content-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Welcome <?php echo $userRow['userName'] ; ?>!</h1>
                    </div>
                </div>
                <div class="row container-fluid">                    
                    <div class="alert alert-warning" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button><p>Displaying total numbers of files per day, week, month and year</p>
                    </div>
                </div>
                <!-- End of Page Heading -->
                
<!-- Notification Badges -->
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class="offer offer-success">
                <div class="shape">
                <?php    
                $stmt = $DB_con->prepare('SELECT *, category.category_id, category.cat_name FROM material JOIN 
                category ON category.category_id = material.category_id WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created) = MONTH(NOW()) AND DAY(date_created) = DAY(NOW())');
                $stmt->execute();    
                $count = $stmt->rowCount();
                ?>
                    <div class="shape-text">
                        <p><?php echo $count; ?></p>                         
                    </div>
                </div>
                <div class="offer-content">
                    <h3 class="lead"><span class="glyphicon glyphicon-calendar"></span> Today</h3>
                        <?php 
                            if ($count != 0) {?> 
                                <p>You have uploaded <?php echo NumbersToWords::convert($count); ?> files today.</p>
                        <?php    }
                            else {?>
                                <p>You haven't uploaded any files today.</p>
                        <?php    }
                        ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class="offer offer-info">
                <div class="shape">
                <?php    
                $stmt = $DB_con->prepare('SELECT *, category.category_id, category.cat_name FROM material JOIN 
                category ON category.category_id = material.category_id WHERE WEEKOFYEAR(date_created) = WEEKOFYEAR(NOW())');
                $stmt->execute();    
                $count = $stmt->rowCount();
                ?>
                    <div class="shape-text">
                        <p><?php echo $count; ?></p>                         
                    </div>
                </div>
                <div class="offer-content">
                    <h3 class="lead"><span class="glyphicon glyphicon-calendar"></span> This Week</h3>
                <?php 
                    if ($count != 0) {?> 
                        <p>You have uploaded <?php echo NumbersToWords::convert($count); ?> files this week.</p>
                <?php    }
                    else {?>
                        <p>You haven't uploaded any files this week.</p>
                <?php    }
                ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class="offer offer-warning">
                <div class="shape">
                <?php    
                $stmt = $DB_con->prepare('SELECT *, category.category_id, category.cat_name FROM material JOIN 
                category ON category.category_id = material.category_id WHERE YEAR(date_created) = YEAR(NOW()) AND MONTH(date_created)=MONTH(NOW())');
                $stmt->execute();    
                $count = $stmt->rowCount();
                ?>
                    <div class="shape-text">
                        <p><?php echo $count; ?></p>                         
                    </div>
                </div>
                <div class="offer-content">
                    <h3 class="lead"><span class="glyphicon glyphicon-calendar"></span> This Month</h3>
                        <?php 
                            if ($count != 0) {?> 
                                <p>You have uploaded <?php echo NumbersToWords::convert($count); ?> files this month.</p>
                        <?php    }
                            else {?>
                                <p>You haven't uploaded any files this.</p>
                        <?php    }
                        ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class="offer offer-danger">
                <div class="shape">
                <?php    
                $stmt = $DB_con->prepare('SELECT *, category.category_id, category.cat_name FROM material JOIN 
                category ON category.category_id = material.category_id WHERE YEAR(date_created) = YEAR(NOW())');
                $stmt->execute();    
                $count = $stmt->rowCount();
                ?>
                    <div class="shape-text">
                        <p><?php echo $count; ?></p>                         
                    </div>
                </div>
                <div class="offer-content">
                    <h3 class="lead"><span class="glyphicon glyphicon-calendar"></span> This Year</h3>
                        <?php 
                            if ($count != 0) {?> 
                                <p>You have uploaded <?php echo NumbersToWords::convert($count); ?> files this year.</p>
                        <?php    }
                            else {?>
                                <p>You haven't uploaded any files this year.</p>
                        <?php    }
                        ?>
                </div>
            </div>
        </div>  
    </div>
                <!-- /.row -->
                
            </div><!-- /.container-fluid -->
        </div><!-- /#page-wrapper -->
        <!-- Ed of Main Screen -->

        </div>

    </div><!-- /#wrapper -->
</div><!-- /.wrap -->

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