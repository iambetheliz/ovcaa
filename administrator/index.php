<?php
include('login.php');
?>
<?php

if(isset($_SESSION['login_admin'])){
header("location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>UP Open University</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/bootstrap-theme.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
</head>
<style type="text/css">
    .profile-img {
    width: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}
</style>
<body>

<div class="wrap">
<div class="container"><br>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong> Sign in to continue</strong>
                    </div>
                    <div class="panel-body">
                        <form action="" method="POST">
                            <fieldset>
                                <div class="row">
                                    <div class="center-block"><br>
                                        <img class="profile-img"
                                            src="../images/logo.png" alt=""><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                        <?php
                                            if(isset($_GET['error'])){
                                        ?>
                                            <div class="alert alert-danger">
                                                <span class="glyphicon glyphicon-info-sign"></span> <strong>You need to login first!</strong>
                                            </div><br>
                                        <?php header("Refresh: 2; url=/ovcaa/administrator");}?>
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
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                </span> 
                                                <input class="form-control" placeholder="Username" name="userName" type="text" autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-lock"></i>
                                                </span>
                                                <input class="form-control" placeholder="Password" name="userPass" type="password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-lg btn-primary btn-block" name="signin" value="Sign in">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="panel-footer ">
                        Don't have an account! <a href="#" onClick=""> Sign Up Here </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
<div class="container">
        <p>&copy; UP Open University 2017</p>
</div>
</footer>

<script src="../assets/js/bootstrap.js"></script>

</body>
</html>