<?php 

function insert_category() {
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
    
        if (empty($cat_title) || trim($cat_title)==""){
            echo "<p style='color: red'> Invalid category name!</p>";
        }
        else {
            $query = "INSERT INTO categories (cat_title) VALUES ('$cat_title')";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die("INSERT QUERY FAILED! ".mysqli_error($connection));
            }
        }
    }
}

function delete_category() {
    global $connection;
    if (isset($_GET['delete_id'])) {

        $delete_id = $_GET['delete_id'];
        $query = "DELETE FROM categories WHERE cat_id = $delete_id";
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die("QUERY FAILED".mysqli_error($connection));
        }
        else {
            header("Location: categories.php");
        }
    }
}

function get_all_categories() {
    global $connection;
    $query = "SELECT * FROM categories";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("QUERY FAILED".mysqli_error($connection));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $cat_id = $row["cat_id"];
        $cat_title = $row["cat_title"]; 
        echo "<tr>
            <td>$cat_id</td>
            <td>$cat_title</td>
            <td><a href='categories.php?delete_id=$cat_id'>Delete</a></td>
            <td><a href='categories.php?edit_id=$cat_id'>Edit</a></td>
            </tr>";

    }
}

function confirmQuery($result)
{
    global $connection;
    if (!$result) 
    {  
        echo "QUERY FAILED! ".mysqli_error($connection);
    }

}
?>