<?php include "INCLUDES/db.php"; ?>
<?php include "INCLUDES/header.php"; ?>

    <!-- Navigation -->
<?php include "INCLUDES/navigation.php"; ?>    

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
<?php 
      $per_page = 3;          
        
     if(isset($_GET['page']))
     {
         $page = Escape($_GET['page']);
     }
     else
     {
         $page = "";
     }
     
                
     if($page == "" || $page == 1)
     {
         $page_1 = 0;
     }
     else
     {
         $page_1 = ($page * $per_page) - $per_page;
     }
                
   
     $post_query_count = "SELECT * FROM posts";           
     $find_count = mysqli_query($connection, $post_query_count);           
     $count = mysqli_num_rows($find_count);           
     
     $count = ceil($count / $per_page);           
                          
                
    $query = "SELECT * FROM posts LIMIT $page_1, $per_page";

    $select_all_posts_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_all_posts_query))
    {
        $post_id = Escape($row['post_id']);
        $post_title = Escape($row['post_title']);
        $post_user = Escape($row['post_user']);
        $post_date = Escape($row['post_date']);
        $post_image = Escape($row['post_image']);
        $post_tags = Escape($row['post_tags']);
        $post_content = Escape(substr($row['post_content'], 0, 1000));        
        $post_comment_count = Escape($row['post_comment_count']);
        $post_status = Escape($row['post_status']);        
        
        if($post_status == "Published")
        {   
       
?>
<!--        <h1><?php //echo $count; ?></h1>-->
          
           <h1 class="page-header">
                    Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- First Blog Post -->
            <h2>
<!--            The link is sending post_id to the post page which will catch the post_id and use it.-->
                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
            </h2>
            <p class="lead">
                by <a href="author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
            <hr>
            
            <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="admin/images/<?php echo $post_image; ?>" alt="Image not found" width="400" height="400">
            </a>
            <hr>
            
            <p><?php echo $post_content; ?></p>
            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>
        
    <?php
            }
        }
    ?>

        
            </div>

            <!-- Blog Sidebar Widgets Column -->
 <?php include "INCLUDES/sidebar.php"; ?>           

        </div>
        <!-- /.row -->

        <hr>
        
<!--        Pagination-->
        <ul class="pager">
<?php
     for($i=1; $i<=$count; $i++)
     {         
         if($i == $page)
         {
             echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
         }
         else
         {
             echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
         }
     }
?>
            
        </ul>
        

 <?php include "INCLUDES/footer.php"; ?>
       