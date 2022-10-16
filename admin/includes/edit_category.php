<?php 
    $query = "SELECT * FROM categories WHERE cat_id = $edit_id";
    $result = mysqli_query($connection, $query);
    $num_of_rows = mysqli_num_rows($result);

    if ($num_of_rows != 1) {
        die("QUERY FAILED ".mysqli_error($connection));
    }
    else {
        $row = mysqli_fetch_assoc($result);
        $existing_cat_title = $row['cat_title'];
?>


        <form action='' method='post'>
            <div class='form-group'>
                <label for='new_cat_title' class='form-label'>New Category name</label>
                <input type='text'  placeholder='<?php echo $existing_cat_title ?>' class='form-control' name='new_cat_title' id='new_cat_title'>
            </div>
            <div class='form-group'>
                <input type='submit' class='btn btn-primary' value='Update category' name='update_category'>
            </div>
        </form>


<?php
    if (isset($_POST['update_category'])) {
        $new_cat_title = $_POST['new_cat_title'];

        $query = "UPDATE categories SET cat_title = '$new_cat_title' WHERE cat_id = $edit_id";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("UPDATE QUERY FAILED ".mysqli_error($connection));
        } else header("Location: categories.php");
    } 
} 
?>
