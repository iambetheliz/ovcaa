<form method="post" enctype="multipart/form-data" action="" autocomplete="off">

<?php
  if(isset($errMSG)){
      ?>
            <div class="alert alert-danger">
              <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div><br>
            <?php
  }
  else if(isset($successMSG)){
    ?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div><br>
        <?php
  }
?>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Category:</label>
    <div class="col-sm-4">
        <?php
            // php select option value from database
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $databaseName = "ovcaa";
            // connect to mysql database
            $connect = mysqli_connect($hostname, $username, $password, $databaseName);
            // mysql select query
            $query = "SELECT * FROM `category` ORDER BY category_id";
            // for method 1
            $result1 = mysqli_query($connect, $query);
            // for method 2
            $result2 = mysqli_query($connect, $query);
            $options = "";
            while($row2 = mysqli_fetch_array($result2))
                  {
                      $options = $options."<option>$row2[1]</option>";
                  }
        ?>
        <script src="../assets/js/jquery.min.js"></script>
        <select name="category_id" class="form-control" id="cat_name">
        <?php
            if(isset($_POST['add_new_cat']) )
              {
                  $cat_name = $_POST['cat_name'];
                  $stmt = $DB_con->prepare('INSERT INTO category(cat_name) VALUES (:cat_name)');
                  $stmt->bindParam(':cat_name',$cat_name);
                  if($stmt->execute())
                      {
                        header('refresh:3;tbl_category.php');
                      }
                  else
                      {
                        $errMSG = "Error!";
                        header('refresh:3;tbl_category.php');
                      }
              }
        ?>  <?php while($row1 = mysqli_fetch_array($result1)):;?>
            <option id="output" value="<?php echo $row1[0];?>"><?php echo $row1[1];?></option>
            <?php endwhile;?>
            <option value="new">Add new category</option>
        </select>
    </div>
  </div>

  <div class="form-group" id="newCat" style="display:none;">
  <label class="col-sm-2 col-form-label"></label>
        <div class="col-sm-4 form-group" id="cname">
                <input type="text" class="form-control" name="cat_name" placeholder="Specify category" autofocus />
        </div>
        <div class="form-inline">
            <button type="submit" id="add" name="add_new_cat" class="btn btn-primary">ADD</button>
      <script type="text/javascript">
        $('#cat_name').on('change',function(){
            if( $(this).val()==="new"){
              $("#newCat").show()
            }
            else{
              $("#newCat").hide()
            }
        });
      </script>
    </div>
  </div>
  </form> 