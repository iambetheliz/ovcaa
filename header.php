<?php
//Include GP config file && User class
include_once 'gpConfig.php';
include_once 'User.php';

if(isset($_GET['code'])){
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . $redirectURL);
}

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    //Get user profile data from google
    $gpUserProfile = $google_oauthV2->userinfo->get();
    
    //Initialize User class
    $user = new User();
    
    //Insert or update user data to the database
    $gpUserData = array(
        'oauth_provider'=> 'google',
        'oauth_uid'     => $gpUserProfile['id'],
        'first_name'    => $gpUserProfile['given_name'],
        'last_name'     => $gpUserProfile['family_name'],
        'email'         => $gpUserProfile['email'],
        'gender'        => $gpUserProfile['gender'],
        'locale'        => $gpUserProfile['locale'],
        'picture'       => $gpUserProfile['picture'],
        'link'          => $gpUserProfile['link']
    );
    $userData = $user->checkUser($gpUserData);
    
    //Storing user data into session
    $_SESSION['userData'] = $userData;
    
    //Render facebook profile data
    $output = '';
    if(!empty($userData)){
        $output .= '<h1>Welcome to UPOU Scribd!</h1>';
        $output .= '<p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>';
        $library = '<a href="uploads.php">'.'<i class="glyphicon glyphicon-book">'.'</i>&nbsp;&nbsp;Library</a>';
        $account = '<p class="navbar-text" style="color:white;"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;'. $userData['first_name'].'&nbsp;'. $userData['last_name'].'</p>';
        $logout = '<a href="logout.php"><i class="glyphicon glyphicon-off">'.'</i>&nbsp;&nbsp;Logout</a>';
    }else{
        $output .= '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }

} else {
    $authUrl = $gClient->createAuthUrl();
    $output = '<h1>Welcome to UPOU Scribd!</h1>';
    $output .= '<p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>';
    $output .= '<p><a class="btn btn-lg btn-danger" href="'.$authUrl.'"><span class="fa fa-google-plus"></span> Sign-in with Google</a></p>';
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>UP Open University</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" defer></script>
<script src="assets/js/bootstrap-submenu.min.js" async defer></script>

<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>

	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
        
          <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" style="color: #f3a22c;" href="/ovcaa"><img class="img-fluid" alt="Brand" src="images/logo.png" width="40" align="left">&nbsp;&nbsp;UP Open University</a>
          </div>

          <div id="navbar" class="navbar-collapse collapse">     
            <ul class="nav navbar-nav navbar-right">
            <?php
                if(!empty($userData)){?>
                <li><?php echo $account; ?></li>
                <li><?php echo $library; ?></li>
                <li><?php echo $logout; ?></li>
            <?php }?>
            </ul>   
          </div><!--/.nav-collapse -->

      </div>
    </nav>

<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>