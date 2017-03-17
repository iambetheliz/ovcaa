<?php
session_start();

//Include Google client library 
include_once '../google/Google_Client.php';
include_once '../google/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '359845811077-5tmabkh7pthfqvgtn89ets51b3cin7s2.apps.googleusercontent.com'; //Google client ID
$clientSecret = '9LieD0wWyd9h9gNIcD1bwdKQ'; //Google client secret
$redirectURL = 'http://localhost/ovcaa/administrator'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('UPOU Scribd');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);
$gClient->setApprovalPrompt('auto');

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>