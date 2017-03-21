<?php  
include_once 'session.php';

unset($_SESSION['login_admin']);

session_destroy();  
header("Location: /ovcaa/administrator");//use for the redirection to some page  
?>  