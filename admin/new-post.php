<?php require_once('./include/header.php');?>

<?php

  if(!isset($_COOKIE['_ua_'])){
    header("Location: sign-in.php");
  }

?>

    <div class="fluid-container">
    <?php require_once('./include/navigation.php');?>
        </nav> <!--End nav-->        

        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
            <h2 class="pb-3">Add New Post</h2>

            <?php
                    if(isset($_POST['create-post'])){
                        $post_title=$_POST['post-title'];
                        $post_cat_id=$_POST['cat-id'];
                        $post_status=$_POST['post-status'];
                        $post_content=$_POST['post-content'];
                        $post_date= date('j F Y');
                        $post_author="Dinesh";
                        $post_image=$_FILES['post-image']['name'];
                        $post_temp_image=$_FILES['post-image']['tmp_name'];
                        move_uploaded_file("{$post_temp_image}", "../img/{$post_image}");
                        
                        if(empty($post_title) || empty($post_cat_id) || empty($post_status) || empty($post_content) || empty($post_image)) {
                            echo "<div class='alert alert-danger'>Field can't be empty!</div>";
                        } else {
                            $insert = "INSERT INTO post (post_title, post_des, post_image, post_date, post_author, post_cat_id, post_status) VALUES(:title, :post, :image, :date, :author, :catid, :status)";
                            $stmt = $pdo->prepare($insert);
                            $stmt->execute([
                                ':title'=>$post_title,
                                ':post'=>$post_content,
                                ':image'=>$post_image,
                                ':date'=>$post_date,
                                ':author'=>$post_author,
                                ':catid'=>$post_cat_id,
                                ':status'=>$post_status
                            ]);
                            echo "<div class='alert alert-success'>Post created successfully. <a href='index.php'>Go back</a></div>";
                        }
                    }
                ?>
                 
                <form action="new-post.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="post-title">Post Title</label>
                    <input name="post-title" type="text" class="form-control" id="post-title" placeholder="Enter post title">
                </div>
                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select name="cat-id" class="form-control" id="category">
                        <?php
                            $select = 'SELECT * FROM categories';
                            $stmt1 = $pdo->prepare($select);
                            $stmt1->execute();
                            while($category = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                $cat_id = $category['cat_id'];
                                $cat_title = $category['cat_title']; ?>
                                echo "<option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>";
                            <?php }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Post Status</label>
                    <select name="post-status" class="form-control" id="category">
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="post-image">Upload post image</label>
                    <input name="post-image" type="file" class="form-control-file" id="post-image">
                </div>
                <div class="form-group">
                    <label for="post-content">Post Content</label>
                    <textarea  name="post-content" class="form-control" id="post-content" rows="6" placeholder="Your post content"></textarea>
                </div>
                <button name="create-post" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </section>

    </div>

    <?php require_once('./include/footer.php');?>