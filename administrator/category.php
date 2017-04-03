<?php
    ob_start();
    session_start();
    require_once '../includes/dbconnect.php';
    
    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin members detail
    $res=mysql_query("SELECT * FROM members WHERE userId=".$_SESSION['user']);
    $userRow=mysql_fetch_array($res);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- jQuery -->
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
<script src="../assets/js/jquery.min.js"></script>
</head>
<body>

<?php
$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;

$per_page = 5; // Set how many records do you want to display per page.


    $search = $_GET['search'];
    $search = mysql_real_escape_string($search);
    $output = 'Showing results for "'.$search.'."';
    
    $startpoint = ($page * $per_page) - $per_page;

    $statement = "`category` WHERE CONCAT(`category_id`, `cat_name`) LIKE '%".$search."%'";

    $results = mysqli_query($conDB,"SELECT * FROM {$statement} ORDER BY $field $sort LIMIT {$startpoint} , {$per_page}");

?>  

<?php
                    if(isset($successMSG)){
                ?>
                    <p class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?>
                    </p>
                <?php
                }
                ?>

<div class="row">
<?php echo pagination($statement,$per_page,$page,$url='?');?> 
</div>

<?php if (isset($_GET['search'])) {
    echo $output;
}  ?>

<div class="row">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" id="table-id">
<thead>
    <tr>               
        <th>Delete</th>
        <th>Category</th>
        
    </tr>
</thead>
<?php
if (mysqli_num_rows($results) != 0){

    // displaying records.
    while ($row = mysqli_fetch_array($results)){
?>
    <tbody>
        <tr>       
            <td class="delete_row">
            <a class="btn btn-danger btn-lg active btn-sm" role="button" aria-pressed="true" href="?delete_id=<?php echo $row['category_id']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
            <td><?php echo $row['cat_name'] ?></td>
            
        <?php
    }
 
} 
else {
     $errMSG = "No Category to display.";
}

?>
                <?php
                    if(isset($errMSG)){
                ?>
                    <td colspan="12" class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                    </td>
                <?php
                }
                ?>
        </tr>
    </tbody>
</table></div>
<?php echo pagination($statement,$per_page,$page,$url='?');?>
</div>
</body>
</html>