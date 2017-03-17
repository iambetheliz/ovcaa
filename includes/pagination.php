<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Pagination - OTallu.com</title>
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

$statement = "`material` JOIN category ON category.category_id = material.category_id ORDER BY `id`"; // Change `records` according to your table name.
 
$results = mysqli_query($conDB,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");

 // displaying paginaiton.
echo pagination($statement,$per_page,$page,$url='?');
?>
<table class="table table-hover table-responsive">
<?php
if (mysqli_num_rows($results) != 0) {
    
	// displaying records.
    while ($row = mysqli_fetch_array($results)) {
?>
    <tbody>
        <tr>
        <td><h3><strong><?php echo $row['title'] ?></strong></h3>
            <small><p>Description: <?php echo $row['description'] ?></p></small>
            <small><p>Category: <?php echo $row['cat_name'] ?></p></small>
        </td>
        <td><br>
        <small><p>Filename: <?php echo $row['filename'] ?></p></small>
            <small><p>Size: <?php echo $row['filesize'] ?>&nbsp;kb</p></small>
            <small><p>Location: <?php echo $row['location'] ?></p></small>
            <small><p>URL: <a href="<?php echo $row['url'] ?>"><?php echo $row['url'] ?></a></p></small>
        </td>
        <td><br>
        <small><p>Uploaded by: <?php echo $row['uploaded_by'] ?></p></small>
            <small><p>Date created: <?php echo $row['date_created'] ?></p></small>
            <small><p>Date modified: <?php echo $row['date_updated'] ?></p></small>
        </td>
        <td><br><a href="edit_file.php?edit_id=<?php echo $row['id']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="glyphicon glyphicon-edit"></span></a> | <a href="?delete_id=<?php echo $row['id']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
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