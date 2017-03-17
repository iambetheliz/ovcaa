<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalNorm">
    Launch Normal Form
</button>

<!-- Modal -->
<div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Modal title
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form method="post" enctype="multipart/form-data" action="add_user.php" autocomplete="off">

                <?php
            if ( isset($errMSG) ) {
                
                ?>
                <div class="form-group">
                <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
                </div>
                <?php
            }
            ?>
                  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Title: (Required)</label>
    <div class="col-sm-4">
    <input type="text" class="form-control" name="title" placeholder="Enter title" value="<?php echo $title; ?>">
    <small id="emailHelp" class="form-text text-muted">Title of your document.</small>
    </div>
  </div>

                  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Description: (Required)</label>
    <div class="col-sm-4">
      <textarea class="form-control" name="description" placeholder="Enter description" id="exampleTextarea" rows="3"><?php echo $description; ?></textarea>
      <small id="emailHelp" class="form-text text-muted">Description of your document.</small>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Category: (Required)</label>
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
            $query = "SELECT * FROM `category`";

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
                        header("Refresh:3; url=upload-document.php"); // redirects image view page after 5 seconds.
                      }
                  else
                      {
                        $errMSG = "error while inserting....";
                      }
              }
        ?>  <option>Select</option>
            <?php while($row1 = mysqli_fetch_array($result1)):;?>
            <option value="<?php echo $row1[0];?>"><?php echo $row1[1];?></option>
            <?php endwhile;?>
            <option value="new">Add new category</option>
        </select>
    </div>
  </div>

  <div class="form-group row" id="newCat" style="display:none;">
  <label class="col-sm-2 col-form-label" for="specify"></label>
    <div class="col-sm-4">
    Specify: <input type="text" class="form-control-file" id="exampleInputFile" name="cat_name" placeholder="Specify category"/>
    <button type="submit" name="add_new_cat" class="btn btn-primary">ADD</button>
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

  <div class="form-group row">
  <label class="col-sm-2 col-form-label"></label>
    <div class="col-sm-4">
    <input type="file" name="file" class="form-control-file" id="exampleInputFile" />
  </div>
  </div>

 <textarea hidden="" name="uploaded_by"><?php echo $userRow['userName']; ?></textarea>
 <textarea hidden="" name="location"><?php echo $location; ?></textarea>
 <textarea hidden="" name="url"><?php echo $url; ?></textarea>

                  <button type="submit" name="btn-upload" class="btn btn-primary"><span class="glyphicon glyphicon-upload"></span> UPLOAD </button> (<?php echo ini_get('upload_max_filesize').'B'; ?>) Max.
                </form>
                
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>