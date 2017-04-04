<?php
require_once 'Material.php';

if(isset($_GET['delete_id']))
 {
  // select image from db to delete
  $stmt_select = $DB_con->prepare('SELECT filename FROM material WHERE id =:id');
  $stmt_select->execute(array(':id'=>$_GET['delete_id']));
  $fileRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
  unlink("../administrator/uploads/".$fileRow['filename']);
  
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM material WHERE id =:id');
  $stmt_delete->bindParam(':id',$_GET['delete_id']);
  $stmt_delete->execute();
  
  header("Location: uploads.php");
 }
?>