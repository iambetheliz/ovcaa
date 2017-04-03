<?php
            if(isset($_POST['add_new_cat']) )
              {
                  $cat_name = $_POST['cat_name'];
                  $stmt = $DB_con->prepare('INSERT INTO category(cat_name) VALUES (:cat_name)');
                  $stmt->bindParam(':cat_name',$cat_name);
                  if($stmt->execute())
                      {
                        header('refresh:1;tbl_category.php');
                      }
                  else
                      {
                        $errMSG = "Error!";
                        header('refresh:1;tbl_category.php');
                      }
              }
        ?>