<?php

//Include GP config file && User class
include_once 'gpConfig.php';
include_once 'User.php';

if(isset($_GET['code'])){
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
  exit;
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
    );

    $userData = $user->checkUser($gpUserData);
    
    //Storing user data into session
    $_SESSION['userData'] = $userData;
    
    //Render facebook profile data
    $output = '';
    if(!empty($userData)){
        $account = '<a href="#"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;'. ucwords($userData['first_name']).'&nbsp;'. ucwords($userData['last_name']).'</a>';
        $logout = '<a href="logout"><i class="glyphicon glyphicon-off">'.'</i>&nbsp;&nbsp;Logout</a>';
    }else{
        $output .= '<h3 class="alert alert-danger">Your google account does not exists in our database!<br>Redirecting to login page ...</h3>';
        header("Refresh:3; logout.php?logout");
    }

} else {

    $stmt = $DB_con->prepare("SELECT * FROM users WHERE role = 'admin'");
    $stmt->execute();    
    $count = $stmt->rowCount();

        if ($count == 0) {
            $disabled = 'disabled';
        }

    $authUrl = $gClient->createAuthUrl();
    $output = '<h1>Welcome to UPOU Scribd!</h1>';
    $output .= '<p><a class="btn btn-lg btn-danger '."<?php echo $disabled ?>".'" id="google" href="'.$authUrl.'"><span class="fa fa-google-plus"></span> Sign-in with Google</a></p>';
}
?>