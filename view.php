<?php

  require_once 'includes/dbconnect.php';

  $DB_con = new mysqli("localhost", "root", "", "ovcaa");

  if ($DB_con->connect_errno) {
    echo "Connect failed: ", $DB_con->connect_error;
  exit();
  }

  require_once 'dbConnect.php';
  
  if(isset($_GET['document']) && !empty($_GET['document']))
  {
    $id = $_GET['document'];
    $stmt = $DB_con->prepare('SELECT * FROM material JOIN 
    category ON category.category_id = material.category_id WHERE filename =:id');
    $stmt->execute(array(':id'=>$id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
  }
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>UP Open University</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<style type="text/css">
/* For pagination function. */
ul.pagination>li>a {
    color:#014421;
}
ul.pagination>li>a.current {
    background:#014421;
    color:#fff;
}
</style>
</head>
<body>
<?php include('header.php'); ?>

<!-- Main Screen -->
<div class="wrap">
    
      <div class="container-fluid">
      <br><br>
      <div class="row">
        <div class="col-sm-3">
          <h4 class="page-header"><strong><?php echo $row['title']; ?></strong></h4>
          <p>Uploaded by <span class="text-primary"><?php echo $row['uploaded_by']; ?></span> on <?php echo date("F j, Y", strtotime($row["date_updated"])); ?></p>
        </div>
    
        <div class="col-lg-9 offset-lg-0">
        <!-- Page Content --><br><br>
            <!-- Iframe -->
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" name="iframe" src="<?php echo $row['url']; ?>"></iframe>
            </div><br>
            <!-- End of Iframe -->
        </div>
        <!-- End of Content --> 
      </div>

      </div><!-- /container -->

</div><!-- /#wrap -->

<footer>
    <div class="container-fluid">
        <p align="right"><a href="/ovcaa/" target="_blank">UP Open University - Scribd</a> &copy; <?php echo date("Y"); ?></p>
    </div>
</footer>

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/index.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</body>
</html>