<?php
    ob_start();
    require_once 'includes/dbconnect.php';
    
    if(isset($_POST['userName']))
{
        session_start();
        $_SESSION['user']=$_POST['userName'];
        //Storing the name of user in SESSION variable.
        header("location: dashboard.php");
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
                header("refresh:5;dashboard.php");
            } else {
                $errMSG = "Incorrect Credentials, Try again...";
                header("refresh:3;index.php");
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
            </div><br>
                                        <div class="form-group">
                <button type="submit" class="btn btn-lg btn-block btn-primary" name="btn-login" data-toggle="modal" data-target="#processing-modal">Sign In</button>
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

<!-- Static Modal -->
<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="../images/ajax_loader_gray_48.gif" class="icon" />
                    <h4>Signing you in ...</h4>
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

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>

</body>
</html>