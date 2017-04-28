<?php
    ob_start();
    require_once '../includes/dbconnect.php';

    $conDB = new mysqli("localhost", "root", "", "ovcaa");

    if ($conDB->connect_errno) {
        echo "Connect failed: ", $conDB->connect_error;
    exit();
    }
    
    session_start();
        if(!isset($_SESSION['user']))
        {
                header("location: /ovcaa/administrator");
        }
        $userName=$_SESSION['user'];

    // select loggedin members detail
    $res = $conDB->query("SELECT * FROM members WHERE userId=".$_SESSION['user'], MYSQLI_USE_RESULT);
    $userRow = $res->fetch_array(MYSQLI_BOTH);
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
<link href="../assets/css/dashboard.css" rel="stylesheet" type="text/css">
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
                <a class="navbar-brand" style="color: #f3a22c;" href="/ovcaa/administrator"><img class="img-fluid" alt="Brand" src="images/logo.png" width="40" align="left">&nbsp;&nbsp;UP Open University</a>
            </div>

            <!-- Top Menu Items -->
            <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $userRow['userName'] ; ?>&nbsp;&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <a href="edit_profile.php" title="Update Profile" ><button type="button" class="btn btn-default"> <strong> &nbsp;&nbsp;Welcome <?php echo $userRow['userName']; ?>!&nbsp;&nbsp; </strong> </button></a>                         
                        <li><a href="logout.php?logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
            </div>

            <!-- Sidebar Menu Items -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="/ovcaa/administrator"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp; Dashboard</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp; Tables &nbsp;&nbsp;<span class="caret"></span></a>
                        <ul id="demo" class="collapse">
                            <li>
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
        <!-- /.navbar-collapse -->
        
        <br><br>
        <!-- Main Screen -->
        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Welcome <?php echo $userRow['userName'] ; ?>!</h1>
                    </div>
                </div>
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
                    <h3 class="lead"><span class="glyphicon glyphicon-briefcase"></span> Today</h3> <p>And a little description. <br> and so one</p>
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
                    <h3 class="lead"><span class="glyphicon glyphicon-briefcase"></span> This Week</h3>
                    <p>And a little description. <br> and so one</p>
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
                    <h3 class="lead"><span class="glyphicon glyphicon-briefcase"></span> This Month</h3>
                    <p>And a little description. <br> and so one</p>
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
                    <h3 class="lead"><span class="glyphicon glyphicon-briefcase"></span> This Year</h3>
                    <p>And a little description. <br> and so one</p>
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
<?php ob_end_flush(); ?>
