<?php
    ob_start();
    session_start();
    require_once '../includes/dbconnect.php';

    $DB_con = new mysqli("localhost", "root", "", "ovcaa");

    if ($DB_con->connect_errno) {
        echo "Connect failed: ", $DB_con->connect_error;
    exit();
    }
    
    // it will never let you open index(login) page if session is set
    if ( isset($_SESSION['user'])!="" ) {
        header("Location: dashboard");
        exit;
    }
    else {
        $loginError = "You need to login first!";
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
        
        if(empty($userName && $pass)){
            $error = true;
            $errMSG = "Incorrect username or password.";
        } else if ( !filter_var($userName) ) {
            $error = true;
            $errMSG = "Please enter valid username.";
        }
        
        // if there's no error, continue to login
        if (!$error) {
            
            $password = hash('sha256', $pass); // password hashing using SHA256
        
            $query = "SELECT userId, userName, userPass FROM members WHERE userName='$userName'";
            $result = $DB_con->query($query);
            $row = $result->fetch_array(MYSQLI_BOTH);
            $row_cnt = $result->num_rows; // if uname/pass correct it returns must be 1 row
            
            if( $row_cnt == 1 && $row['userPass']==$password ) {
                $_SESSION['user'] = $row['userId'];
                $successMSG = "Signing in";
                header("refresh:3;dashboard.php");
            } else {
                $errMSG = "Incorrect Credentials, Try again...";
            }
            
            $result->close();
        }
        
    }
    $DB_con->close();
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>UP Open University</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/bootstrap-theme.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style type="text/css">
    .profile-img {
    width: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%; }
</style>
<body>

<div class="wrap">
<div class="container">
    <div class="row">
        <div class="center-block">
            <a href="/ovcaa/administrator"><img class="profile-img" src="../images/logo.png" alt="UPOU logo" /></a>
            <center><h3>Sign in to UPOU Scribd</h3></center><br>
        </div>
    </div>
    <div class="row">
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
        <?php
            if ( isset($_GET['loginError']) ) {
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
        <?php
            if ( isset($errMSG) ) {
        ?>
            <div class="form-group">
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $errMSG; ?>
                </div>
            </div>
        <?php
            }
        ?>
            <div class="panel panel-default">

                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 "><br>     
                                <div class="form-group">
                                    <strong>Username</strong>
                                    <input type="text" id="username" name="userName" class="form-control" value="<?php echo $userName; ?>" maxlength="20" autofocus />
                                </div>
                                <div class="form-group">
                                    <strong>Password</strong>
                                    <input name="pass" id="password" class="form-control" type="password" maxlength="20" />
                                </div>
                                <div class="form-group">
                                    <?php
                                        if ( isset($successMSG) ) {
                                    ?>
                                    <button type="submit" class="btn btn-block btn-success" name="btn-login">Signing in ...</button><br>
                                    <?php
                                        } else {?>
                                    <button type="submit" class="btn btn-block btn-success" name="btn-login">Sign In</button><br>
                                    <?php    }
                                    ?>
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

<footer class="footer">
    <div class="container">
        <p align="right">UP Open University - Scribd &copy; <?php echo date("Y"); ?></p>
    </div>
</footer>

<!-- jQuery -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
<script src="../assets/js/bootstrap-show-password.js"></script>
<script>
    $(function() {
        $('#password').password().on('show.bs.password', function(e) {
            $('#eventLog').text('On show event');
            $('#methods').prop('checked', true);
        }).on('hide.bs.password', function(e) {
                    $('#eventLog').text('On hide event');
                    $('#methods').prop('checked', false);
                });
        $('#methods').click(function() {
            $('#password').password('toggle');
        });
    });
</script>

</body>
</html>
<?php ob_end_flush(); ?>