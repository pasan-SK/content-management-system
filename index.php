<!-- admin username: rodgerD, pwd: 123 -->

<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<?php session_start() ?>

    <!-- Navigation  *** Note: session_start() method is in this--> 
    <?php require "includes/navigation.php" ?>
    

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    myCMS
                    <small>popular courses..</small>
                </h1>

                <!-- Blog Posts -->

                <?php 
                    if(isset($_GET['author']))
                    {
                        $author = $_GET['author'];
                        $query = "SELECT * FROM posts WHERE post_status='published' AND post_author='$author'";
                        $query_result = mysqli_query($connection, $query);

                        if (!(mysqli_num_rows($query_result) >= 1)) {
                            echo "<h2>No published posts found from author: $author, sorry.</h2>";
                        } 
                    }
                    else 
                    {
                        $isPageSet = false;
                        $query = "SELECT * FROM posts WHERE post_status='published'";
                        $query_result = mysqli_query($connection, $query);

                        if (!(mysqli_num_rows($query_result) >= 1)) {
                            echo "<h2>No published posts found, sorry.</h2>";
                        } 
                        else 
                        {
                            $posts_count = mysqli_num_rows($query_result);
                            $posts_count_per_page = 5;
                            $num_of_pages = ceil($posts_count/$posts_count_per_page);

                            
                            $isPageSet = true;

                            if(isset($_GET['page']))
                            {
                                $current_page = $_GET['page'];
                            }
                            else {
                                $current_page = 1;
                            }
                            
                            $all_results = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
                            for ($i=$posts_count_per_page*($current_page - 1); $i < $posts_count_per_page*($current_page); $i++)
                            {
                                if(empty($all_results[$i])) break;

                                $row = $all_results[$i]; 
                                
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                $post_author = $row['post_author'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = substr($row['post_content'],0,200)."...";
                                $post_last_edited = $row['post_last_edited'];

                                ?>

                                    <h2>
                                        <a href="post.php?post_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                                    </h2>
                                    <p class="lead">
                                        by <a href="index.php?author=<?php echo $post_author ?>"><?php echo $post_author ?></a>
                                    </p>
                                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?>
                                    <?php
                                        if (!empty($post_last_edited)) {
                                            echo ", Last edited on $post_last_edited";
                                        }
                                    ?>
                                    </p>
                                    <hr>
                                    <a href="post.php?post_id=<?php echo $post_id ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt="post image is missing"></a>
                                    <hr>
                                    <p><?php echo $post_content ?></p>
                                    <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                                    <hr>

                            <?php
                            }  
                        }
                    }
                    ?>
                            

                <!-- //Pager
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul> -->

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                
            <?php if ($posts_count) : 
                for ($i=1; $i <= $num_of_pages; $i++) : 

                    if ($i == $current_page) :?>
                         <li class="page-item"><a  style="background-color: #000080;" class="page-link" href="index.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>  
                         
                     <?php continue;
                        endif ?>

                    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>  

            <?php endfor ?>             
            <?php endif ?>
                
            </ul>
        </nav>
        <!-- Footer -->
        <?php include "includes/footer.php" ?>

    
