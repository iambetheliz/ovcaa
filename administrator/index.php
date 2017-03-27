<?php
    ob_start();
    session_start();
    require_once '../includes/dbconnect.php';
    
    // it will never let you open index(login) page if session is set
    if ( isset($_SESSION['user'])!="" ) {
        header("Location: dashboard.php");
        exit;
    }
    
    $error = false;
    
    if( isset($_POST['btn-login']) ) {  
        
        // prevent sql injections/ clear user invalid inputs

        $userName = trim($_POST['userName']);
        $userName = strip_tags($userName);
        $userName = htmlspecialchars($userName);
        
        $pass = trim($_POST['pass']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);
        // prevent sql injections / clear user invalid inputs
        
        if(empty($userName)){
            $error = true;
            $userNameError = "Please enter your username.";
        } else if ( !filter_var($userName) ) {
            $error = true;
            $userNameError = "Please enter valid username.";
        }
        
        if(empty($pass)){
            $error = true;
            $passError = "Please enter your password.";
        }
        
        // if there's no error, continue to login
        if (!$error) {
            
            $password = hash('sha256', $pass); // password hashing using SHA256
        
            $res=mysql_query("SELECT userId, userName, userPass FROM members WHERE userName='$userName'");
            $row=mysql_fetch_array($res);
            $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
            
            if( $count == 1 && $row['userPass']==$password ) {
                $_SESSION['user'] = $row['userId'];
                $successMSG = "<h3 align='center'>Signing in ...</h3>";
                header("refresh:3;dashboard.php");
            } else {
                $errMSG = "Incorrect Credentials, Try again...";
            }
                
        }
        
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
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
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
                                            if ( isset($errMSG) ) {
                                        ?>
                                        <div class="form-group">
                                            <div class="alert alert-danger">
                                                <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        <?php
                                            if ( isset($successMSG) ) {
                                        ?>
                                        <div class="form-group">
                                            <div class="alert alert-success">
                                                    <?php echo $successMSG; ?>
                                                    <div class="center-block">
                                                        <center><img src="../images/ajax_loader_blue_32.gif" class="icon" /></center><br>
                                                    </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        <div class="form-group">
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input type="text" name="userName" class="form-control" placeholder="Username" value="<?php echo $userName; ?>" maxlength="40" autofocus />
                </div>
                <span class="text-danger"><?php echo $userNameError; ?></span>
            </div>
                                        <div class="form-group">
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                <input type="password" name="pass" class="form-control" placeholder="Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
                                        <div class="form-group"><br>
                <button type="submit" class="btn btn-lg btn-block btn-primary" name="btn-login">Sign In</button><br>
            </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
<div class="container">
        <p align="right">UP Open University - Scribd &copy; <?php echo date("Y"); ?></p>
</div>
</footer>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
<script src="../assets/js/bootstrap.js"></script>

</body>
</html>
<?php ob_end_flush(); ?>