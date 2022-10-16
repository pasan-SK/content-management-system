    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                All users
            </h1>
        </div>
    </div>
    <!-- /.row -->

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Image</th>
                <th>Role</th>
                <th colspan="2">Change to</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

<?php 
    $query = "SELECT user_id, username, user_firstname, user_lastname, user_email, user_image, user_role FROM users";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
?>

        <tr>
            <td><?php echo $user_id ?></td>
            <td><?php echo $username ?></td>
            <td><?php echo $user_firstname ?></td>
            <td><?php echo $user_lastname ?></td>
            <td><?php echo $user_email ?></td>
            <td><img width="100" src="../images/<?php echo $user_image ?>" alt="user image is missing"></td>
            <td><?php echo $user_role ?></td>

            <td><a href="users.php?changeToAdmin_id=<?php echo $user_id ?>">Admin</a></td>
            <td><a href="users.php?changeToSubscriber_id=<?php echo $user_id ?>">Subscriber</a></td>
            <td><a href="users.php?source=edit_user&edit_user_id=<?php echo $user_id ?>">Edit</a></td>
            <td><a href="users.php?del_id=<?php echo $user_id ?>" onclick="return confirm('Are you sure you want to delete?');">Delete</a></td>
        </tr>

  <?php } ?>
        </tbody>
    </table>

<?php //when 'delete' is pressed
    if (isset($_GET['del_id'])) {
        $del_id = $_GET['del_id'];

        $query3 = "DELETE FROM users WHERE user_id = $del_id";
        $result3 = mysqli_query($connection, $query3);
        confirmQuery($result3);

        // $query4 = "DELETE FROM comments WHERE comment_post_id = $del_id";
        // $result4 = mysqli_query($connection, $query4);
        // confirmQuery($result4);

        header("Location: users.php");
    }

    //when 'Admin' is pressed
    if (isset($_GET['changeToAdmin_id'])) {
        $changeToAdmin_id = $_GET['changeToAdmin_id'];

        $query3 = "UPDATE users SET user_role='admin' WHERE user_id = $changeToAdmin_id";
        $result3 = mysqli_query($connection, $query3);
        confirmQuery($result3);

        header("Location: users.php");
    }

    //when 'Subscriber' is pressed
    if (isset($_GET['changeToSubscriber_id'])) {
        $changeToSubscriber_id = $_GET['changeToSubscriber_id'];

        $query3 = "UPDATE users SET user_role='subscriber' WHERE user_id = $changeToSubscriber_id";
        $result3 = mysqli_query($connection, $query3);
        confirmQuery($result3);

        header("Location: users.php");
    }
?>
