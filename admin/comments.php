<?php include "../includes/db.php" ?>
<?php include "includes/admin_header.php" ?>
<?php include "functions.php" ?>
<?php session_start() ?>

<?php

if (!isset($_SESSION['password_mismatch']) && !isset($_SESSION['not_admin'])) {
    header("Location: ../");
}
if ($_SESSION['password_mismatch'] == false && $_SESSION['not_admin'] == false) {
    $username = $_SESSION['username'];
} else {
    header("Location: ../");
}

?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <?php 
                    if (isset($_GET['source'])) {
                        $source = $_GET['source'];
                    }
                    else $source = '';

                    switch ($source) {
                        // case 'add_post':
                        //     include "includes/add_post.php";
                        //     break;

                        // case 'edit_post':
                        //     include "includes/edit_post.php";
                        //     break;
                        
                        default:
                            include "includes/view_all_comments.php";
                            break;
                    }
                        
                ?>

                
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/admin_footer.php" ?>

    