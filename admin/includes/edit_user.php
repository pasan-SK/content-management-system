<!-- Page Heading -->
<div class="row">
        <div class="col-lg-12">
        <h1 class="page-header">
            Edit User
        </h1>
    </div>
</div>
<!-- /.row -->

<?php

    $edit_user_id = $_GET['edit_user_id'];
    $query = "SELECT * FROM users WHERE user_id=$edit_user_id";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    $row = mysqli_fetch_assoc($result);

    $username = $row['username'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
    $user_role = $row['user_role'];

    if (isset($_POST['submit'])) 
    {
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];

        if (!empty($_FILES['user_image']['name'])) 
        {
            $user_image = $_FILES['user_image']['name'];
            $user_image_tmp_name = $_FILES['user_image']['tmp_name'];
            move_uploaded_file($user_image_tmp_name, "../images/$user_image");    
        }

        $randSalt_query = "SELECT randSalt FROM users LIMIT 1";
        $ranSalt_query_result = mysqli_query($connection, $randSalt_query);
        confirmQuery($ranSalt_query_result);
        $salt = mysqli_fetch_assoc($ranSalt_query_result)['randSalt'];
        $user_password = crypt($user_password, $salt);

        $query = "UPDATE users SET username='$username', user_password='$user_password', user_firstname='$user_firstname', user_lastname='$user_lastname', user_email='$user_email', user_role='$user_role', user_image='$user_image' WHERE user_id=$edit_user_id";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        header("Location: users.php");
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username:</label>
        <input class="form-control" type="text" name="username" value="<?php echo $username?>">
    </div>

    <div class="form-group">
        <label for="user_password">Password:</label>
        <input class="form-control" type="password" name="user_password" value="<?php /*echo $user_password */?>">
    </div>

    <div class="form-group">
        <label for="user_email">Email:</label>
        <input class="form-control" type="email" name="user_email" value="<?php echo $user_email?>">
    </div>

    <div class="form-group">
        <label for="user_firstname">Firstname:</label>
        <input class="form-control" type="text" name="user_firstname" value="<?php echo $user_firstname?>">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname:</label>
        <input class="form-control" type="text" name="user_lastname" value="<?php echo $user_lastname?>">
    </div>

    <div class="form-group">
        <label for="user_role">User role:</label>
        <select class="form-control" name="user_role" id="user_role">
            <?php
                if ($user_role == "admin") {
                    echo "<option value='admin' selected>admin</option>
                        <option value='subscriber'>subscriber</option>";
                } else {
                    echo "<option value='subscriber' selected>subscriber</option>
                        <option value='admin'>admin</option>";
                }      
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="user_current_image">Current user image:</label> <br>
        <img width="100" src="../images/<?php echo $user_image?>" alt="current user image is missing" id="user_current_image">   
    </div>

    <div class="form-group">
        <label for="user_image">Change user image:</label>
        <input type="file" name="user_image">    
    </div>

    <button type="submit" class="btn btn-primary" name="submit">Submit</button>

</form>