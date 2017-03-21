<?php
include('session.php'); // Includes Login Script

session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
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

$startpoint = ($page * $per_page) - $per_page;

$statement = "`users` ORDER BY `id`"; // Change `records` according to your table name.
 
$results = mysqli_query($conDB,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");

 // displaying paginaiton.
echo pagination($statement,$per_page,$page,$url='?');
?>
<table class="table table-bordered table-hover table-responsive">
<thead>
        <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Date Added</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
    </thead>
<?php
if (mysqli_num_rows($results) != 0) {
    
	// displaying records.
    while ($row = mysqli_fetch_array($results)) {
?>  
    <tbody>
        <tr>
        <td><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?></td>
        <td><?php echo $row['email'] ?></td>
        <td><?php echo $row['created'] ?></td>
        <td><?php echo $row['status'] ?></td>
        <td><a href="edit_file.php?edit_id=<?php echo $row['id']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="glyphicon glyphicon-edit"></span></a> | <a href="?delete_id=<?php echo $row['id']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
        </tr>
    </tbody>
<?php
    }
 
} 
else {
     $errMSG = "No files to display. Click <a href='upload-document.php'>here</a> to upload new files.";
}

?>
</table>
<?php 
 // displaying paginaiton.
echo pagination($statement,$per_page,$page,$url='?');
?>

</body>
</html>