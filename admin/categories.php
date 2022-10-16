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

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Categories
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="container">
                    <div class="col-xs-6">

                        <!-- code to be executed when 'add category' button is pressed -->
                        <?php insert_category(); ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title" class="form-label">Category name</label>
                                <input type="text" class="form-control" name="cat_title" id="cat_title">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Add category" name="submit">
                            </div>
                        </form>

                        <!-- code to be executed when 'Edit' link is clicked -->
                        <?php
                            if (isset($_GET['edit_id'])) {

                                $edit_id = $_GET['edit_id'];
                                include "includes/edit_category.php";
                            }
                        ?>
                    </div>

                    <div class="col-xs-6">

                        <!-- code to be executed when 'delete' link is clicked -->
                        <?php delete_category(); ?>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category name</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- query to get categories from database -->
                                <?php get_all_categories();  ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/admin_footer.php" ?>

    