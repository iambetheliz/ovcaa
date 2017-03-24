<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>UP Open University</title>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/bootstrap-theme.css" rel="stylesheet">
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="wrap">
<?php include 'header.php'; ?>
        <div class="container-fluid"><br><br><br><br><br>
                <div class="site-index">
                    <div class="jumbotron">  
                        <?php echo $output; ?>                      
                    </div>
                </div>
        </div>
</div>

<footer class="footer">
<div class="container-fluid">
        <p align="right">UP Open University - Scribd &copy; <?php echo date("Y"); ?></p>
</div>
</footer>

<script src="../assets/js/bootstrap.js"></script>
</body>
</html>