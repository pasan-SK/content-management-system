<!-- Page Heading -->
<div class="row">
        <div class="col-lg-12">
        <h1 class="page-header">
            Add Post
        </h1>
    </div>
</div>
<!-- /.row -->

<?php
    if (isset($_POST['publish'])) {
        $post_title = $_POST['post_title'];
        $post_cat_id = $_POST['post_cat_id'];
        $post_author = $_POST['post_author'];
        $post_status = $_POST['post_status'];

        $post_image_name = $_FILES['post_image']['name'];
        $post_image_tmp_name = $_FILES['post_image']['tmp_name'];
        move_uploaded_file($post_image_tmp_name, "../images/$post_image_name");
        
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        $post_date = date('Y-m-d');
        $post_comment_count = 0;

        $query = "INSERT INTO posts VALUES (DEFAULT, $post_cat_id, '$post_title', '$post_author', now(), '$post_image_name', '$post_content', '$post_tags', $post_comment_count, '$post_status', DEFAULT)";
        //note that instead of now() function in the query, we can also use  '$post_date' since it is in Y-m-d format
        $result = mysqli_query($connection, $query);

        if (!$result) {
            echo "QUERY FAILED! " . mysqli_error($connection);
        } else {
            $new_post_id = mysqli_insert_id($connection);
            echo "<p style='color: green'>Successfully created the post    
                  <a href='../post.php?post_id=$new_post_id' class='btn btn-secondary'>View Post</a> 
                  <a href='posts.php?source=edit_post&edit_id=$new_post_id' class='btn btn-secondary'>Edit Post</a></p>";
        }
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post title:</label>
        <input class="form-control" type="text" name="post_title">
    </div>

    <div class="form-group">
        <label for="post_cat_id">Post category id:</label>
        <select class="form-control" name="post_cat_id" id="post_cat_id">
        <?php
            $query2 = "SELECT * FROM categories";
            $query_result2 = mysqli_query($connection, $query2);
            confirmQuery($query_result2);
            
            while ($row2 = mysqli_fetch_assoc($query_result2)) {
                $cat_title = $row2['cat_title'];
                $cat_id = $row2['cat_id'];
                echo "<option value='$cat_id'>$cat_title</option>";
            }
        ?>
        
        </select>
    </div>


    <div class="form-group">
        <label for="post_author">Post author:</label>
        <input class="form-control" type="text" name="post_author">
    </div>

    <div class="form-group">
        <label for="post_status">Post status:</label>
        <select class="form-control" name="post_status" id="post_status">
            <option value="published">published</option>
            <option value="draft">draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post image:</label>
        <input type="file" name="post_image">    
    </div>

    <div class="form-group">
        <label for="post_tags">Post tags:</label>
        <input class="form-control" class="form-control-file" type="text" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post content:</label>
        <textarea id="editor" class="form-control" name="post_content" rows="4"></textarea>
    </div>

    <script defer>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

    <button type="submit" class="btn btn-primary" name="publish">Publish</button>

</form>