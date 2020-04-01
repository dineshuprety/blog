<?php require_once('./include/header.php'); ?>
<?php
  if(!isset($_COOKIE['_ua_'])) {
    header("Location: sign-in.php");
  }
?>

<?php
    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        header("Location: index.php");
    }

    if(isset($_POST['val'])) {
        $pid = $_POST['val'];
        $select = "SELECT * FROM post WHERE post_id = :pid";
        $stmt = $pdo->prepare($select);
        $stmt->execute([
            ':pid'=>$pid
        ]);
        while($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post_id = $post['post_id'];
            $post_title = $post['post_title'];
            $post_cat_id = $post['post_cat_id'];
            $post_status = $post['post_status'];
            $post_image = $post['post_image'];
            $post_content = $post['post_des'];
        }
    }
?>
    <div class="fluid-container">
    <?php require_once('./include/navigation.php'); ?>  
    </nav>    

        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
            <h2 class="pb-3">Edit Post</h2>
            <?php
                if(isset($_POST['update-post'])) {
                    $post_title = $_POST['post-title'];
                    $post_cat_id = $_POST['cat-id'];
                    $post_status = $_POST['post-status'];
                    $post_content = $_POST['post-content'];
                    $postid = $_POST['edit-post-id'];
                    $post_date = date('j F Y');
                    $post_author = "Dinesh";
                    $post_image = $_FILES['post-image']['name'];
                    $post_temp_image = $_FILES['post-image']['tmp_name'];
                    move_uploaded_file("{$post_temp_image}", "../img/{$post_image}");
                    if(empty($post_image)) {
                        $select2 = "SELECT * FROM post WHERE post_id = :id";
                        $stmt3 = $pdo->prepare($select2);
                        $stmt3->execute([
                            ':id' => $postid
                        ]);
                        while($p = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                            $post_image = $p['post_image'];
                        };
                    }
                    
                   
                    if(empty($post_title) || empty($post_cat_id) || empty($post_status) || empty($post_content)) {
                        echo "<div class='alert alert-danger'>Field can't be empty!</div>";
                    } else {
                        //echo "try !";
                        $update = "UPDATE post SET post_title = :title, post_des = :post, post_image = :image, post_date = :date, post_author = :author, post_cat_id = :catid, post_status = :status WHERE post_id = :postid";
                        $stmt = $pdo->prepare($update);
                        $stmt->execute([
                            ':title'=>$post_title,
                            ':post'=>$post_content,
                            ':image'=>$post_image,
                            ':date'=>$post_date,
                            ':author'=>$post_author,
                            ':catid'=>$post_cat_id,
                            ':status'=>$post_status,
                            ':postid'=>$postid
                        ]);
                        header("Location: index.php");
                    }
                }
            ?>
            <form method="POST" action="edit-post.php" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" value="<?php echo $post_id; ?>" name="edit-post-id" />
                    <label for="post-title">Post Title</label>
                    <input name="post-title" value="<?php echo $post_title; ?>" type="text" class="form-control" id="post-title" placeholder="Enter post title">
                </div>
                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select name="cat-id" class="form-control" id="category">
                    <?php
                            $sql1 = 'SELECT * FROM categories';
                            $stmt1 = $pdo->prepare($sql1);
                            $stmt1->execute();
                            while($category = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                $cat_id = $category['cat_id'];
                                $cat_title = $category['cat_title']; ?>
                                echo "<option value="<?php echo $cat_id; ?>" <?php echo $cat_id == $post_cat_id?'selected':'' ?>><?php echo $cat_title; ?></option>";
                            <?php }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Post Status</label>
                    <select name="post-status" class="form-control" id="category">
                        <option <?php echo $post_status == 'published'?'selected':'' ?>>Published</option>
                        <option <?php echo $post_status == 'draft'?'selected':'' ?>>Draft</option>
                    </select>
                </div>
                <div class="form-group">
                    <img src="../img/<?php echo $post_image; ?>" style="width:50px;height:50px" />
                    <label for="post-image">Upload post image</label>
                    <input name="post-image" type="file" class="form-control-file" id="post-image">
                </div>
                <div class="form-group">
                    <label for="post-content">Post Content</label>
                    <textarea name="post-content" class="form-control" id="post-content" rows="6" cols="30" placeholder="Your post content"><?php echo $post_content; ?></textarea>
                </div>
                <input name="update-post" type="submit" class="btn btn-primary" value="Update post">
            </form>
        </section>

    </div>

<?php  require_once('./include/footer.php'); ?>