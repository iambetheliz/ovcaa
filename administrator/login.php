<?php

session_start(); // Starting Session

if (isset($_POST['signin'])) {
    if (empty($_POST['userName']) || empty($_POST['userPass'])) {
        $errMSG = "Fields cannot be empty! Try again<br><br>";
        header("Refresh: 2; url=/ovcaa/administrator");
    }
    else 
    {
        // Define $userName and $userPass
        $userName=$_POST['userName'];
        $userPass=$_POST['userPass'];
        // Establishing Connection with Server by passing server_name, user_id and userPass as a parameter
        $connection = mysql_connect("localhost", "root", "");
        // To protect MySQL injection for Security purpose
        $userName = stripslashes($userName);
        $userPass = stripslashes($userPass);
        $userName = mysql_real_escape_string($userName);
        $userPass = mysql_real_escape_string($userPass);
        // Selecting Database
        $db = mysql_select_db("ovcaa", $connection);
        // SQL query to fetch information of registerd users and finds user match.
        $query = mysql_query("select * from members where userPass='$userPass' AND userName='$userName'", $connection);
        $rows = mysql_num_rows($query);
        
        if ($rows == 1) {
            $_SESSION['login_admin']=$userName; // Initializing Session    
            $successMSG = "Successfully logged in!";     
            header("Refresh:2; url=dashboard.php");
            
        } 
        else {
            $errMSG = "Invalid credentials. Try again";
            header("Refresh: 2; url=/ovcaa/administrator");
        }
    
    mysql_close($connection); // Closing Connection
    }
}
?>