<?php 
    
    //To get the id value from the url
    if(isset($_GET['p_id']))
    {
        $the_post_id = Escape($_GET['p_id']);
    }

        //Take the data from the db where the id = id of the url
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_posts_by_id = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_posts_by_id))
        {
            $post_id = Escape($row['post_id']);
            $post_category_id = Escape($row['post_category_id']);
            $post_title = Escape($row['post_title']);
            $post_user = Escape($row['post_user']);
            $post_date = Escape($row['post_date']);
            
            $post_image = Escape($row['post_image']);
            $post_content = Escape($row['post_content']);
            $post_tags = Escape($row['post_tags']);
            $post_comment_count = Escape($row['post_comment_count']);
            $post_status = Escape($row['post_status']);
        }

    if(isset($_POST['update_post']))
    {
         // Pick from the input box to the exact variables holding data from the db in the above. Thereby changing them. This section is basically for the post_category and image settings.
        $post_category_id = Escape($_POST['post_category']);
        $post_title = Escape($_POST['post_title']);
        $post_user = Escape($_POST['post_user']);
        $post_status = Escape($_POST['post_status']);
        
        $post_image = Escape($_FILES['image']['name']);
        $post_image_temp = Escape($_FILES['image']['tmp_name']);
        $post_tags = Escape($_POST['post_tags']);
        $post_content = Escape($_POST['post_content']);

                
//        Making the image stay when update post is clicked.
        move_uploaded_file($post_image_temp, "images/$post_image");
        
        if(empty($post_image))
        {
            $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
            $select_image = mysqli_query($connection, $query);
            
            while($row = mysqli_fetch_array($select_image))
            {
                $post_image = Escape($row['post_image']);
            }
            
        }
        
        // Put back to the data into the DB.
        $query = "UPDATE posts SET ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_user = '{$post_user}', ";
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_image = '{$post_image}', ";
        $query .= "post_date = now(), ";
        $query .= "post_content = '{$post_content}' ";             
        $query .= "WHERE post_id = {$the_post_id} ";
        
        $update_post = mysqli_query($connection, $query);

        ConfirmQuery($update_post); 
        
        echo "Post updated. <a class='bg-success'; href='../post.php?p_id={$the_post_id}'> View posts </a> or <a href='posts.php'> Edit more posts</a>";
    }

?>

   <form action="" method="post" enctype="multipart/form-data">
   <!--Enctype is in charge of sending form data.-->
           
       <div class="col-xs-6">
           
           <p class="form-group">
                <label for="title">Post Title</label>
                <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
           </p>          

            <p class="form-group">
<!--               To show the options of the category from the category table incase it also need to be changed-->
           <label for="categories">Categories:</label>
            <select name="post_category" id="" class="form-control">
           
<?php         
    
    $query = "SELECT * FROM categories ";
    $select_categories = mysqli_query($connection, $query);
                       
    ConfirmQuery($select_categories);                   
                       
    while($row = mysqli_fetch_assoc($select_categories))
    {
        $cat_id = Escape($row['cat_id']);
        $cat_title = Escape($row['cat_title']);
        
        echo "<option value='$cat_id'>{$cat_title}</option>";
        
    }
        
?>
    
              </select>
          
           </p>

            <p class="form-group">
<!--               To show the options of the users from the users -->
           <label for="users">Users:</label>
            <select class="form-control" name="post_user" id="">
            
<?php echo "<option value='$post_user'>{$post_user}</option>"; ?>
                        
<?php         
    
    $user_query = "SELECT * FROM users ";
    $select_users = mysqli_query($connection, $user_query);
                       
    ConfirmQuery($select_users);                   
                       
    while($row = mysqli_fetch_assoc($select_users))
    {
        $user_id = Escape($row['user_id']);
        $username = Escape($row['username']);
        
        echo "<option value='$username'>{$username}</option>";
        
    }     
?>
            
              </select>
              
           </p>
            
            <div class="form-group">               
                <select name='post_status' id='' class="form-control">
                    <option value='Draft'><?php echo $post_status; ?></option>
                    
<?php

     if($post_status == 'Published')
     {
         echo "<option value='Draft'>Draft</option>";
     }
     else
     {
         echo "<option value='Published'>Publish</option>";
     }

?>
         
                </select>
            </div>
            
            <p class="form-group">
                <label for="post_image">Post Image</label><br>
                <img width="100" src="images/<?php echo $post_image; ?>" alt="Image">
                <input type="file" name="image">
            </p>

            <p class="form-group">
                <label for="post_tags">Post Tags</label>
                <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
            </p>

            <p class="form-group">
                <label for="post_content">Post Content</label> <br>
                <textarea class="form-control" name="post_content" id="body" cols="30" rows="10" >
                
                <?php echo $post_content; ?>
                
                </textarea>
            </p>

            <p class="form-group">            
                <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
            </p>                        
        
       </div>     
    </form>
    