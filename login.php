<?php
//Include GP config file && User class
include_once 'gpConfig.php';
include_once 'User.php';

session_start();

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
        $library .= '<a href="uploads.php">'.'<i class="glyphicon glyphicon-book">'.'</i>&nbsp;&nbsp;Library</a>';
        $account .= '<p class="navbar-text" style="color:white;"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;'. $userData['first_name'].'&nbsp;'. $userData['last_name'].'</p>';
        $logout .= '<a href="logout.php"><i class="glyphicon glyphicon-off">'.'</i>&nbsp;&nbsp;Logout</a>';
    }else{
        $output .= '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }

} else {
    $authUrl = $gClient->createAuthUrl();
    $output = '<h1>Welcome to UPOU Scribd!</h1>';
    $output .= '<p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>';
    $output .= '<p><a class="btn btn-lg btn-danger" href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><span class="fa fa-google-plus"></span>G+ Sign-in with Google</a></p>';
}
?>