<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>   
 
    <?php
        if (isset($_POST['submit'])) {
            $username = mysqli_real_escape_string($connection, $_POST['username']);
            $email = mysqli_real_escape_string($connection, $_POST['email']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);

            if (empty($username) || empty($email) || empty($password)) {
                echo "<script>alert('Fields cannot be empty!')</script>";
            }

            if (strlen($username) > 200 || strlen($email) > 200 || strlen($password) > 200) {
                echo "<script>alert('A field cannot have more than 200 characters!')</script>";
            }

            else {
                $query1 = "SELECT randSalt FROM users";
                $result1 = mysqli_query($connection, $query1);
                confirmQuery($result1);
                $row = mysqli_fetch_assoc($result1);
                mysqli_free_result($result1);
                $salt = $row['randSalt'];

                $password = crypt($password, $salt);
                $query2 = "INSERT INTO users(username, user_password, user_email, user_role) VALUES ('$username', '$password', '$email', 'admin')";
                $result2 = mysqli_query($connection, $query2);
                confirmQuery($result2);
            }
        }
    ?>


    <!-- Page Content -->
    <div class="container">
    
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                            <h1>Register</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                </div>
                        
                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>


        <hr>

<?php include "includes/footer.php";?>
