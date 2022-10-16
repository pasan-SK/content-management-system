<!-- Page Heading -->
<div class="row">
        <div class="col-lg-12">
        <h1 class="page-header">
            Add User
        </h1>
    </div>
</div>
<!-- /.row -->

<?php
    if (isset($_POST['submit'])) 
    {
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];

        $user_image_name = $_FILES['user_image']['name'];
        $user_image_tmp_name = $_FILES['user_image']['tmp_name'];
        move_uploaded_file($user_image_tmp_name, "../images/$user_image_name");

        $query = "INSERT INTO users(user_id, username, user_password, user_firstname, user_lastname, user_email, user_image, user_role) VALUES (DEFAULT, '$username', '$user_password', '$user_firstname', '$user_lastname', '$user_email', '$user_image_name','$user_role')";

        $result = mysqli_query($connection, $query);
        if (!$result) {
            echo "QUERY FAILED! " . mysqli_error($connection);
        } else {
            $new_user_id = mysqli_insert_id($connection);
            echo "<p style='color: green'>Successfully created the user     
                  <a href='users.php?source=edit_user&edit_user_id=$new_user_id' class='btn btn-secondary'>Edit user</a>
                  <a href='users.php' class='btn btn-secondary'>View all users</a></p>";
        }
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username:</label>
        <input class="form-control" type="text" name="username">
    </div>

    <div class="form-group">
        <label for="user_password">Password:</label>
        <input class="form-control" type="password" name="user_password">
    </div>

    <div class="form-group">
        <label for="user_email">Email:</label>
        <input class="form-control" type="email" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_firstname">Firstname:</label>
        <input class="form-control" type="text" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname:</label>
        <input class="form-control" type="text" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_role">User role:</label>
        <select class="form-control" name="user_role" id="user_role">
            <option value="admin">admin</option>
            <option value="subscriber">subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <label for="user_image">User image:</label>
        <input type="file" name="user_image">    
    </div>

    <button type="submit" class="btn btn-primary" name="submit">Submit</button>

</form>