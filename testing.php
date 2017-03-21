<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $results = "SELECT * FROM `material` JOIN category ON category.category_id = material.category_id WHERE CONCAT(`id`, `title`, `description`, `cat_name`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($results);
    
}
 else {
    $results = "SELECT * FROM `material` JOIN category ON category.category_id = material.category_id";
    $search_result = filterTable($results);
}

// function to connect and execute the results
function filterTable($results)
{
    $connect = mysqli_connect("localhost", "root", "", "ovcaa");
    $filter_Result = mysqli_query($connect, $results);
    return $filter_Result;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHP HTML TABLE DATA SEARCH</title>
        <style>
            table,tr,th,td
            {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        
        <form action="" method="post">
            <input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
            <input type="submit" name="search" value="Filter"><br><br>
            
            <table>
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>category_id</th>
                </tr>

      <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><?php echo $row['title'];?></td>
                    <td><?php echo $row['description'];?></td>
                    <td><?php echo $row['cat_name'];?></td>
                </tr>
                <?php endwhile;?>
            </table>
        </form>
        
    </body>
</html>