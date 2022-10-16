

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS Front</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                
                <?php 
                    $query = "SELECT * FROM categories";
                    $query_result = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($query_result)) {
                        $cat_title = $row['cat_title'];
                        echo "<li><a href='#'>$cat_title</a></li>";
                    }
                ?>

                <li>
                    <a href="admin">Admin</a>
                </li>

                <li>
                    <a href="registration.php">Registration</a>
                </li>

                <?php 
                    if (isset($_GET['post_id'])) {
                        $edit_post_id = $_GET['post_id'];
                        echo "<li><a href='admin/posts?source=edit_post&edit_id=$edit_post_id'>Edit</a></li>";
                    }
                ?>
                
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>