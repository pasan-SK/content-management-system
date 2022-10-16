<?php

if (!isset($_SESSION['password_mismatch']) && !isset($_SESSION['not_admin'])) {
    header("Location: ../");
}
if ($_SESSION['password_mismatch'] == false && $_SESSION['not_admin'] == false) {
    //good to go
} else {
    header("Location: ../");
}

?>

<!-- Page Heading -->
<div class="row">
        <div class="col-lg-12">
        <h1 class="page-header">
            Edit Post
        </h1>
    </div>
</div>
<!-- /.row -->

<?php

    $edit_id = $_GET['edit_id'];
    $query = "SELECT * FROM posts WHERE post_id=$edit_id";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    confirmQuery($result);

    $post_title = $row['post_title'];
    $post_cat_id = $row['post_category_id'];
    $post_author = $row['post_author'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content = $row['post_content'];

    if (isset($_POST['publish'])) {
        $post_title = $_POST['post_title'];
        $post_cat_id = (int) $_POST['post_cat_id'];
        $post_author = $_POST['post_author'];
        $post_status = $_POST['post_status'];

        if (!empty($_FILES['post_image']['name'])) 
        {
            $post_image = $_FILES['post_image']['name'];
            $post_image_tmp_name = $_FILES['post_image']['tmp_name'];
            move_uploaded_file($post_image_tmp_name, "../images/$post_image");    
        }
                
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];

        $query = "UPDATE posts SET post_category_id=$post_cat_id, post_title='$post_title', post_author='$post_author', post_image='$post_image', post_content='$post_content', post_tags='$post_tags', post_status='$post_status', post_last_edited=now() WHERE post_id=$edit_id";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        header("Location: posts.php");
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post title:</label>
        <input class="form-control" type="text" name="post_title" value='<?php echo $post_title ?>'>
    </div>

    <div class="form-group">
        <label for="post_cat_id">Post category id:</label>
        <select class="form-control" name="post_cat_id" id="post_cat_id">
        <?php
            $query = "SELECT * FROM categories";
            $query_result = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($query_result)) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                if ($cat_id == $post_cat_id) {
                    echo "<option value='$cat_id' selected>$cat_title</option>";    
                }
                else echo "<option value='$cat_id'>$cat_title</option>";
            }
        ?>
        
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Post author:</label>
        <input class="form-control" value='<?php echo $post_author ?>' type="text" name="post_author">
    </div>

    <div class="form-group">
        <label for="post_status">Post status:</label>
        <select class="form-control" name="post_status" id="post_status">
            <option value="published" <?php if($post_status=='published') echo 'selected' ?>>published</option>
            <option value="draft" <?php if($post_status=='draft') echo 'selected' ?>>draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="curr_img">Current post image:</label> <br>
        <img width="100" id="curr_img" src="../images/<?php echo $post_image ?>" alt="current course image is missing"> 
    </div>

    <div class="form-group">
        <label for="post_image">Change post image:</label>
        <input type="file" value='<?php echo $post_image?>' name="post_image">    
    </div>

    <div class="form-group">
        <label for="post_tags">Post tags:</label>
        <input class="form-control" value='<?php echo $post_tags ?>' class="form-control-file" type="text" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post content:</label>
        <textarea class="form-control" name="post_content" rows="4"><?php echo $post_content ?> </textarea>
    </div>

    <button type="submit" class="btn btn-primary" name="publish">Publish</button>

</form>