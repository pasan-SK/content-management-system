<?php //when 'Apply' is pressed
    if (isset($_POST['apply'])) 
    {
        if (isset($_POST['checkBoxArray'])) 
        {
            $checkBoxArray = $_POST['checkBoxArray'];
            $bulk_option = $_POST['bulkOptions'];

            if (empty($bulk_option)) {
                echo "<p style='color: red'>Please select an option to be applied</p>";
            }

            foreach ($checkBoxArray as $selected_post_id) 
            {
                if ($bulk_option === "publish") 
                {
                    $option_query_publish = "UPDATE posts SET post_status='published' WHERE post_id=$selected_post_id";
                    $option_query_publish_result = mysqli_query($connection, $option_query_publish);
                    confirmQuery($option_query_publish_result);                 
                } 
                else if ($bulk_option === "draft")
                {
                    $option_query_draft = "UPDATE posts SET post_status='draft' WHERE post_id=$selected_post_id";
                    $option_query_draft_result = mysqli_query($connection, $option_query_draft);
                    confirmQuery($option_query_draft_result);
                    
                }
                else if ($bulk_option === "delete")
                {
                    $option_query_delete = "DELETE FROM posts WHERE post_id=$selected_post_id";
                    $option_query_delete_result = mysqli_query($connection, $option_query_delete);
                    confirmQuery($option_query_delete_result);
                    
                }    
            }
            
        }
        else 
        {
            echo "<p style='color: red'>Please select a post to apply changes</p>";
        }
    }
?>
    
    
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                All Posts
            </h1>
        </div>
    </div>
    <!-- /.row -->


    <form action="" method="post">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select name="bulkOptions" id="" class="form-control">
                <option value="">Select an option</option>
                <option value="publish">publish</option>
                <option value="draft">draft</option>
                <option value="delete">delete</option>
            </select>
        </div>

        <div class="col-xs-4">
            <button type="submit" name="apply" class="btn btn-success">Apply</button>
            <a href="posts.php?source=add_post" class="btn btn-primary">Add new post</a>
        </div>

    
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" name="selectAll" id="selectAllBox" onclick="selectAllCheckBoxes()"></th>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

    <?php 
        $query = "SELECT post_id, post_author, post_title, post_category_id, post_status, post_image, post_tags, post_comment_count, post_date FROM posts ORDER BY post_id DESC";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];

            $query2 = "SELECT * FROM categories WHERE cat_id = $post_category_id";
            $result2 = mysqli_query($connection, $query2);
            confirmQuery($result2);

            $row2 = mysqli_fetch_assoc($result2);
            $cat_title = $row2['cat_title'];
    ?>

                <tr>
                    <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value=<?php echo $post_id ?>></td>
                    <td><?php echo $post_id ?></td>
                    <td><?php echo $post_author ?></td>
                    <td><a href="../post.php?post_id=<?php echo $post_id ?>"><?php echo $post_title ?></a></td>

                    <td><?php echo $cat_title ?></td>

                    <td><?php echo $post_status ?></td>
                    <td><img width="100" src="../images/<?php echo $post_image ?>" alt="course image is missing"></td>
                    <td><?php echo $post_tags ?></td>
                    <td><?php echo $post_comment_count ?></td>
                    <td><?php echo $post_date ?></td>
                    <td><a href="posts.php?source=edit_post&edit_id=<?php echo $post_id ?>">Edit</a></td>
                    <td><a href="posts.php?del_id=<?php echo $post_id ?>">Delete</a></td>
                </tr>

    <?php } ?>
            </tbody>
        </table>
    </form>

<?php //when 'delete' is pressed
    if (isset($_GET['del_id'])) {
        $del_id = $_GET['del_id'];

        $query3 = "DELETE FROM posts WHERE post_id = $del_id";
        $result3 = mysqli_query($connection, $query3);
        confirmQuery($result3);

        $query4 = "DELETE FROM comments WHERE comment_post_id = $del_id";
        $result4 = mysqli_query($connection, $query4);
        confirmQuery($result4);

        header("Location: posts.php");
    }
?>

