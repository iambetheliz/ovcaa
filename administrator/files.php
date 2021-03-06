<?php

  include 'dbConnect.php';
  include 'header.php';

  if(!isset($_SESSION['token'])){
    header("Location: index.php?loginError");
  }
  
  require_once '../includes/dbconnect.php';

  $DB_con = new mysqli("localhost", "root", "", "ovcaa");

  if ($DB_con->connect_errno) {
    echo "Connect failed: ", $DB_con->connect_error;
  exit();
  }
  
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- jQuery -->
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script type="text/javascript">
function delete_confirm(){
    var result = confirm("Are you sure to delete these documents?");
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
</head>
<body>

<?php
    require_once '../includes/dbconnect.php';

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
            $output = "<div class='row alert alert-danger' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Please enter a keyword.</div>";
        }
        else {
            $output = '<div class="row alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Showing result for <strong>"'.$search.'."</strong></div>';
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

<div class="container-fluid">
<?php if(!empty($_SESSION['success_msg'])){ ?>
    <div class="row alert alert-success"><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><?php echo $_SESSION['success_msg']; ?></div>
    <?php unset($_SESSION['success_msg']); 
} ?>

<?php
  if(isset($successMSG)){
?>
    <div class="row alert alert-success"><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
       <span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?>
    </div>
<?php
    }
?>

<?php if (isset($_GET['search'])) {
    echo $output;
}  ?>

<!-- Container Fluid -->
<div class="row">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" id="table-id">
<thead>
    <tr>
        <th><input type="checkbox" name="select_all" id="select_all" value=""/></th>
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
  /**
   * Formats bytes to a human readable representation.
   * 
   * @param int $bytes
   *
   * @return string
   */
  function format_filesize($bytes) {
    $labels = array(' B', ' KB', ' MB', ' GB', ' TB');
    
    foreach($labels AS $label){
      if ($bytes > 1024){
        $bytes = $bytes / 1024;
      }
      else {
        break;
      }
    }
    
    return round($bytes, 2) . $label;
  }
?>
<?php
if ($result->num_rows != 0) { ?>

    <tbody>
    <?php 
    // displaying records.
    while ($row = $result->fetch_assoc()){ ?>
        <tr>
            <td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row['id']; ?>"/></td>
            <td>
            <a class="btn btn-primary btn-lg active btn-sm" role="button" aria-pressed="true" href="edit_file.php?edit_id=<?php echo $row['id']; ?>" title="click for edit"> <span class="glyphicon glyphicon-edit"></span></a>
            </td>
            <td class="delete_row">
            <a class="btn btn-danger btn-lg active btn-sm" role="button" aria-pressed="true" href="?delete_id=<?php echo $row['id']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
            <td><?php echo $msg .$row['title'] ?></td>
            <td><p><?php echo $row['description'] ?></p></td>
            <td><p><?php echo $row['cat_name'] ?></p></td>
            <td><p><?php echo $row['filename'] ?></p></td>
            <td><p><?php echo format_filesize($row['filesize']) ?></p></td>
            <td><p><?php echo $row['location'] ?></p></td>
            <td><p><a href="view.php?document=<?php echo $row['filename'] ?>" target="_blank">https://goo.gl/96bNKI<?php echo $row['id'] ?></a></p></td>
            <td><p><?php echo $row['uploaded_by'] ?></p></td>
            <td><p><?php echo date('l; F j, Y; g:i a', strtotime($row['date_created'])) ?></p></td>
            <td><p><?php echo date('l; F j, Y; g:i a', strtotime($row['date_updated'])) ?></p></td>
        </tr>
    <?php 
    } 
}else { ?>
        <tr><td colspan="14">No records found.</td></tr> 
    </tbody>
    <?php } ?>
</table>
</div>
</div> 
<!-- end of container-fluid -->

<?php echo pagination($statement,$per_page,$page,$url='?');?> 
</div>
</body>
</html>