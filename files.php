<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Pagination</title>
</head>
<body>

<?php
    require_once 'includes/dbconnect.php';

    $DB_con = new mysqli("localhost", "root", "", "ovcaa");

    if ($DB_con->connect_errno) {
        echo "Connect failed: ", $DB_con->connect_error;
    exit();
    }

    $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
    if ($page <= 0) $page = 1;

    $per_page = 10; // Set how many records do you want to display per page.

    if (isset($_GET['search'])) {

    $search = $_GET['search'];
    $search = $DB_con->real_escape_string($search);
    
        if (empty($search)) {
            $output1 = "<div class='row alert alert-danger' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Please enter a keyword.</div>";
        }
        else {
            $output1 = '<div class="row alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Showing result for <strong>"'.$search.'."</strong></div>';
        }
    
    $startpoint = ($page * $per_page) - $per_page;

    $statement = "`material` JOIN category ON category.category_id = material.category_id WHERE CONCAT(`id`, `title`, `filename`,`description`, `cat_name`, `uploaded_by`) LIKE '%".$search."%'";

    $result = mysqli_query($DB_con,"SELECT * FROM {$statement} ORDER BY $field $sort LIMIT {$startpoint} , {$per_page}");

}
else {

    $startpoint = ($page * $per_page) - $per_page;

    $statement = "`material` JOIN category ON category.category_id = material.category_id WHERE CONCAT(`id`, `title`, `filename`,`description`, `cat_name`, `uploaded_by`)";

    $result = mysqli_query($DB_con,"SELECT * FROM {$statement} ORDER BY $field $sort LIMIT {$startpoint} , {$per_page}");
    
}

?>   

<?php if (isset($_GET['search'])) {
    echo $output1;
}  ?>
<br>
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
if ($result->num_rows != 0) { ?>

    <tbody>
    <?php 
    // displaying records.
    while ($row = $result->fetch_assoc()){ ?>
        <tr>
        <td><br><p><strong><?php echo $row['title'] ?></strong></p></td>
        <td><br>
            <p>Description: <?php echo $row['description'] ?></p>
            <p>Category: <?php echo $row['cat_name'] ?></p>
            <p>URL: <a href="view.php?title=<?php echo $row['filename'] ?>" target="_blank">https://goo.gl/96bNKI<?php echo $row['id'] ?></a></p>
        </td>
        <td><br>
        <p><?php echo $row['uploaded_by'] ?></p>
        </td>
        <td><br>
        <p><?php echo date("F j, Y g:i a", strtotime($row["date_updated"])); ?></p>
        </td>
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
                    <td colspan="4" class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                    </td>
                <?php
                }
                ?>
        </tr>
    </tbody>
</table>
</div>
</div>
<?php echo pagination($statement,$per_page,$page,$url='?');?>

</body>
</html>