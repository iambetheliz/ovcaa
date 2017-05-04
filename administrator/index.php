<?php

session_start();
include 'dbConnect.php';
include 'header.php';

if ( isset($_SESSION['token'])!="" ) {
        header("Location: dashboard");
        exit;
    }
else {
        $loginError = "You need to login first!";
    }

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>UP Open University</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="359845811077-5tmabkh7pthfqvgtn89ets51b3cin7s2.apps.googleusercontent.com">
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
    .site-index {
        margin-top: 10%;
    }
</style>
</head>

<body>
<div class="wrap">

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
            
        </div>
        </nav>

        <div class="container-fluid">
                <div class="site-index">
                <?php
            		if ( isset($_GET['loginError']) ) {
            			$loginError = "You need to login first!";
        		?>
            		<div class="form-group">
                		<div class="alert alert-danger alert-dismissible" role="alert">
                    		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    		<?php echo $loginError; ?>
                		</div>
            		</div>
        		<?php
            		}
        		?>
                    <div class="jumbotron" style="background: transparent;text-align: center;"> 
                        <?php echo $output; ?>   
                    </div>                   
                </div>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p align="right">UP Open University - Scribd &copy; <?php echo date("Y"); ?></p>
    </div>
</footer>

<script src="../assets/js/bootstrap.js"></script>
</body>
</html>