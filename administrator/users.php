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
<!-- end of jQuery -->
<style type="text/css">
ul.pagination li.page_info {
    display: inline;
    -webkit-margin-before: 1em;
    -webkit-margin-after: 1em;
    -webkit-margin-start: 0px;
    -webkit-margin-end: 0px;
    -webkit-padding-start: 40px;
}

/* For pagination function. */
ul.pagination {
    text-align:center;
    color:#829994;
}
ul.pagination li {
    display:inline;
    padding:0 3px;
}
ul.pagination a {
    color:#014421;
    display:inline-block;
    padding:5px 10px;
    border:1px solid #cde0dc;
    text-decoration:none;
}
ul.pagination a:hover,
ul.pagination a.current {
    background:#014421;
    color:#fff;
}
</style>
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

    $statement = "`members` WHERE CONCAT(`userId`, `userName`, `first_name`, `last_name`, `userEmail`, `regDate`) LIKE '%".$search."%'"; 
 
    $results = mysqli_query($conDB,"SELECT * FROM {$statement}  ORDER BY $field $sort LIMIT {$startpoint} , {$per_page}");

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
        <th><center>Action</center></th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Date Added</th>
    </tr>
</thead>
<?php
if (mysqli_num_rows($results) != 0) {
    
	// displaying records.
    while ($row = mysqli_fetch_array($results)) {
?>  
    <tbody>
        <tr>
            
            <td><center>
            <a class="btn btn-danger btn-lg active btn-sm" role="button" aria-pressed="true" href="?delete_id=<?php echo $row['userId']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-trash"></span>&nbsp; Delete</a></center>
            </td>
            <td><?php echo $row['userName'] ?></td>
            <td><?php echo $row['first_name'] ?></td>
            <td><?php echo $row['last_name'] ?></td>
            <td><?php echo $row['userEmail'] ?></td>
            <td><p><?php echo date('l; F j, Y; g:i a', strtotime($row['regDate'])) ?></p></td>
<?php
    }
 
} 
else {
     $errMSG = "No files to display.";
}

?>
                <?php
                    if(isset($errMSG)){
                ?>
                    <td colspan="6" class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                    </td>
                <?php
                }
                ?>
        </tr>
    </tbody>
</table></div>
<?php 
echo pagination($statement,$per_page,$page,$url='?');
?>
</div>
</body>
</html>

<script type="text/javascript">    
$(document).ready(function() {
$(".first").click(function() {
$("#checkAll").attr("data-type", "uncheck");
});
$("input[name=option2]").click(function() {
$("#selectall").prop("checked", false);
});
$("#checkAll").attr("data-type", "check");
$("#checkAll").click(function() {
if ($("#checkAll").attr("data-type") === "check") {
$(".first").prop("checked", true);
$("#checkAll").attr("data-type", "uncheck");
} else {
$(".first").prop("checked", false);
$("#checkAll").attr("data-type", "check");
}
})
$("#selectall").click(function() {
$(".second").prop("checked", $("#selectall").prop("checked"))
})
});
</script>