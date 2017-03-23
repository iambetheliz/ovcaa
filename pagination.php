<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Pagination</title>
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
    padding:0 5px;
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

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $results = mysqli_query($conDB,"SELECT * FROM `material` JOIN category ON category.category_id = material.category_id WHERE CONCAT(`id`, `title`, `description`, `cat_name`) LIKE '%".$valueToSearch."%'");
}
 else {

$startpoint = ($page * $per_page) - $per_page;

$statement = "`material` JOIN category ON category.category_id = material.category_id"; // Change `records` according to your table name.
 
$results = mysqli_query($conDB,"SELECT * FROM {$statement} ORDER BY $field $sort LIMIT {$startpoint} , {$per_page}");

}

?>  

<div class="row">
<?php echo pagination($statement,$per_page,$page,$url='?');?> 
</div>

<div class="row">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" id="table-id">
<thead>
    <tr>
        <th>Title</th>
        <th>Details</th>
        <th>Uploader</th>
        <th>Date Published</th>
    </tr>
</thead>
<?php
if (mysqli_num_rows($results) != 0) {

    // displaying records.
    while ($row = mysqli_fetch_array($results)) {
?>
    <tbody>
        <tr>
        <td><h3><strong><?php echo $row['title'] ?></strong></h3></td>
        <td><br>
            <small><p>Description: <?php echo $row['description'] ?></p></small>
            <small><p>Category: <?php echo $row['cat_name'] ?></p></small>
            <small><p>URL: <a target="_blank" href="<?php echo $row['url'] ?>"><?php echo $row['url'] ?></a></p></small>
        </td>
        <td><br>
        <small><p>Uploaded by: <?php echo $row['uploaded_by'] ?></p></small>
        </td>
        <td><br>
        <small><p>Published on: <?php echo date("F j, Y g:i a", strtotime($row["date_updated"])); ?></p></small>
        </td>
        </tr>
    </tbody>
<?php
    }
 
} 
else {
     $errMSG = "No results to display.";
}
?>
</table></div>
<?php echo pagination($statement,$per_page,$page,$url='?');?>
</div>

</body>
</html>