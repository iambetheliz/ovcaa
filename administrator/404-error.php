<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="403 Forbidden">
<title>404 Not Found</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<style>
/* Error Page Inline Styles */
body {
  padding-top: 20px;
}
/* Layout */
.jumbotron {
  font-size: 21px;
  font-weight: 200;
  line-height: 2.1428571435;
  color: inherit;
  padding: 10px 0px;
  margin-top: 5%;
}
/* Everything but the jumbotron gets side spacing for mobile-first views */
.masthead, .body-content, {
  padding-left: 15px;
  padding-right: 15px;
}
/* Main marketing message and sign up button */
.jumbotron {
  text-align: center;
  background-color: transparent;
}
.jumbotron .btn {
  padding: 14px 24px;
}
/* Colors */
.green {color:#5cb85c;}
.orange {color:#f0ad4e;}
.red {color:#d9534f;}
.maroon {color:#7b1113;}
.profile-img {
width: 200px;
margin: 0 auto 10px;
display: block;
-moz-border-radius: 50%;
-webkit-border-radius: 50%;
border-radius: 50%; }
</style>
<script type="text/javascript">
  function loadDomain() {
    var display = document.getElementById("display-domain");
    display.innerHTML = document.domain;
  }
</script>
</head>
<body onload="javascript:loadDomain();">
<!-- Error Page Content -->
<div class="container">
<div class="jumbotron">
  <h2><i class="fa fa-frown-o red"></i> <strong>File Not Found</strong></h2><hr>
    <p>The link you followed may be broken, or the page may have been removed.</p>
    <p><a href="javascript:history.go(-1)" class="btn btn-default btn-lg"><span class="maroon">Go back to previous page</a></p>
</div>
</div>
<!-- End Error Page Content -->
<div class="center-block">
  <img class="profile-img" src="../images/logo.png" alt="UPOU logo" />
</div>
<br><br>
    <footer class="footer">
        <div class="container">
            <p align="center">UP Open University - Scribd &copy; <?php echo date("Y"); ?></p>
        </div>
    </footer>
<!--Scripts-->
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
