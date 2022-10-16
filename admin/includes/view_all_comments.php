    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                All Comments
            </h1>
        </div>
    </div>
    <!-- /.row -->

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response to</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

<?php 
    $query = "SELECT comment_id, comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date FROM comments";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    while ($row = mysqli_fetch_assoc($result)) {
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_email = $row['comment_email'];
        $comment_content = $row['comment_content'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];

        $query2 = "SELECT post_title FROM posts WHERE post_id=$comment_post_id";
        $result2 = mysqli_query($connection, $query2);
        confirmQuery($result2);

        $row = mysqli_fetch_assoc($result2);
        $comment_post_title = $row['post_title'];
?>

            <tr>
                <td><?php echo $comment_id ?></td>
                <td><?php echo $comment_author ?></td>
                <td><?php echo $comment_content ?></td>
                <td><?php echo $comment_email ?></td>
                <td><?php echo $comment_status ?></td>
                <td><a href="../post.php?post_id=<?php echo $comment_post_id ?>"><?php echo $comment_post_title ?></a></td>
                <td><?php echo $comment_date ?></td>
                <td><a href="comments.php?approve_com_id=<?php echo $comment_id ?>">Approve</a></td>
                <td><a href="comments.php?unapprove_com_id=<?php echo $comment_id ?>">Unapprove</a></td>
                <td><a href="comments.php?del_com_id=<?php echo $comment_id ?>">Delete</a></td>
            </tr>

<?php } ?>
        </tbody>
    </table>

<?php //when 'delete' is pressed
    if (isset($_GET['del_com_id'])) {
        $del_com_id = $_GET['del_com_id'];

        $query3 = "DELETE FROM comments WHERE comment_id = $del_com_id";
        $result3 = mysqli_query($connection, $query3);
        confirmQuery($result3);
        header("Location: comments.php");
    }

    //when 'approve' is pressed
    if (isset($_GET['approve_com_id'])) {
        $approve_com_id = $_GET['approve_com_id'];

        $query4 = "UPDATE comments SET comment_status='approved' WHERE comment_id = $approve_com_id";
        $result4 = mysqli_query($connection, $query4);
        confirmQuery($result4);
        header("Location: comments.php");
    }

    //when 'unapprove' is pressed
    if (isset($_GET['unapprove_com_id'])) {
        $unapprove_com_id = $_GET['unapprove_com_id'];

        $query5 = "UPDATE comments SET comment_status='unapproved' WHERE comment_id = $unapprove_com_id";
        $result5 = mysqli_query($connection, $query5);
        confirmQuery($result5);
        header("Location: comments.php");
    }
?>
