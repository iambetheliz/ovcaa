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

    $statement = "`material` JOIN category ON category.category_id = material.category_id WHERE CONCAT(`id`, `title`, `filename`,`description`, `cat_name`, `uploaded_by`) LIKE '%".$search."%'";

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
        <th>Edit</th>
        <th>Delete</th>
        <th>Title</th>
        <th>Description</th>
        <th>Category</th>
        <th>Filename</th>
        <th>Filesize</th>
        <th>Location</th>
        <th>URL</th>
        <th>Uploader</th>
        <th>Date Created</th>
        <th>Date Modified</th>
    </tr>
</thead>
<?php
if (mysqli_num_rows($results) != 0){

    // displaying records.
    while ($row = mysqli_fetch_array($results)){
?>
    <tbody>
        <tr>            
            <td>
            <a class="btn btn-primary btn-lg active btn-sm" role="button" aria-pressed="true" href="edit_file.php?edit_id=<?php echo $row['id']; ?>" title="click for edit"> <span class="glyphicon glyphicon-edit"></span></a>
            </td>
            <td class="delete_row">
            <a class="btn btn-danger btn-lg active btn-sm" role="button" aria-pressed="true" href="?delete_id=<?php echo $row['id']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
            <td><?php echo $row['title'] ?></td>
            <td><p><?php echo $row['description'] ?></p></td>
            <td><p><?php echo $row['cat_name'] ?></p></td>
            <td><p><?php echo $row['filename'] ?></p></td>
            <td><p><?php echo $row['filesize'] ?>&nbsp;kb</p></td>
            <td><p><?php echo $row['location'] ?></p></td>
            <td><p><a href="<?php echo $row['url'] ?>" target="_blank"><?php echo $row['url'] ?></a></p></td>
            <td><p><?php echo $row['uploaded_by'] ?></p></td>
            <td><p><?php echo date('l; F j, Y; g:i a', strtotime($row['date_created'])) ?></p></td>
            <td><p><?php echo date('l; F j, Y; g:i a', strtotime($row['date_updated'])) ?></p></td>
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

<script type="text/javascript">
function deleteConfirm(){
    var result = confirm("Are you sure to delete users?");
    if(result){
        return true;
    }else{
        return false;
    }
}

$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
</script>

</body>
</html>