<?php include "db.php" ?>
<?php include "../admin/functions.php" ?>
<?php session_start() ?>

<?php

if(isset($_POST['login']))
{
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);

    $query = "SELECT * FROM users WHERE username='$username' AND user_password='$user_password'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    $row = mysqli_fetch_assoc($result);
    $user_role = $row['user_role'];

    if (mysqli_num_rows($result) == 1 and $user_role == 'admin') 
    {
        $_SESSION['username'] = $username;
        $_SESSION['password_mismatch'] = false;
        $_SESSION['not_admin'] = false;
        header("Location: ../admin");    
    } 
    else if (mysqli_num_rows($result) == 1 and $user_role == 'subscriber') 
    {
        $_SESSION['password_mismatch'] = false;
        $_SESSION['not_admin'] = true;
        header("Location: ../");   
    } 
    else if (mysqli_num_rows($result) != 1) 
    {
        $_SESSION['password_mismatch'] = true;
        $_SESSION['not_admin'] = false;
        header("Location: ../");   
    } 
}

?>