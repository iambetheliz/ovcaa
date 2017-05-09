<?php
    session_start();
    require_once '../includes/dbconnect.php';

  $DB_con = new mysqli("localhost", "root", "", "ovcaa");

  if ($DB_con->connect_errno) {
    echo "Connect failed: ", $DB_con->connect_error;
  exit();
  }

    if(isset($_POST['bulk_delete_submit'])){
        $idArr = $_POST['checked_id'];
        foreach($idArr as $id){
            mysqli_query($DB_con,"DELETE FROM users WHERE uid=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        header("Location:tbl_users.php");
    }
?>