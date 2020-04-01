<?php require_once('./include/header.php'); ?>
<?php
  if(!isset($_COOKIE['_ua_'])) {
    header("Location: sign-in.php");
  }
?>
    <div class="fluid-container">
        <?php require_once('./include/navigation.php'); ?>   
        </nav>  

        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2">
        <?php
            if(isset($_POST['add-new-cat'])) {
                $cat_title =trim($_POST['cat-title']);
                if(empty($cat_title)) {
                    $error = "<div class='alert alert-danger'>Field can't be blank!</div>";
                } else {
                    $insert = "INSERT INTO categories (cat_title) VALUE (:catt)";
                    $stmt = $pdo->prepare($insert);
                    $stmt->execute([
                        ':catt'=>$cat_title
                    ]);
                    header("Location: categories.php");
                }
            }
        ?>
            <form action="categories.php" method="POST" class="py-4">
                <div class="row">
                    <div class="col">
                        <input name="cat-title" type="text" class="form-control" placeholder="Enter category name">
                    </div>
                    <div class="col">
                        <input name="add-new-cat" type="submit" class="form-control btn btn-secondary" value="Add New Category">
                        <?php if(isset($error)) {
                            echo $error;
                        } ?>
                    </div>
                </div>
            </form>
            <?php
                if(isset($_POST['update-cat'])) {
                    $cat_t = trim($_POST['cat-t']);
                    if(empty($cat_t)) {
                        echo "<div class='alert alert-danger'>Sorry it can't be empty!</div>";
                    } else {
                    $catid = $_POST['value'];
                    $update = "UPDATE categories SET cat_title = :title WHERE cat_id = :catid";
                    $stmt1 = $pdo->prepare($update);
                    $stmt1->execute([
                        ':title'=>$cat_t,
                        ':catid'=>$catid
                    ]);
                    header("Location: categories.php"); }
                }
                if(isset($_POST['update-category'])) {
                    $id = $_POST['edit-cat-id'];
                    $tit = $_POST['edit-cat-title'];?>
                    <form action="categories.php" method="POST" class="py-4">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" value="<?php echo $id; ?>" name="value"/>
                                <input value="<?php echo $tit; ?>" name="cat-t" type="text" class="form-control" placeholder="Enter category name">
                            </div>
                            <div class="col">
                                <input name="update-cat" type="submit" class="form-control btn btn-primary" value="Update Category">
                            </div>
                        </div>
                    </form>
                <?php }
                
            ?>

            


            <h2>All Categories</h2>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category name</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>
                <tbody>  
                <?php
                    $select = "SELECT * FROM categories";
                    $stmt2 = $pdo->prepare($select);
                    $stmt2->execute();
                    while($category = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $cat_id = $category['cat_id'];
                        $cat_title = $category['cat_title'];?>
                        <tr>
                            <td><?php echo $cat_id; ?></td>
                            <td><?php echo $cat_title; ?></td>
                            <td>
                                <form method="POST" action="categories.php">
                                    <input type='hidden' name="edit-cat-title" value="<?php echo $cat_title; ?>" />
                                    <input type="hidden" name="edit-cat-id" value="<?php echo $cat_id; ?>"/>
                                    <input type="submit" name="update-category" value="Edit" class="btn btn-link"/>
                                </form>
                            </td>
                            <td>
                                <form action="categories.php" method="POST">
                                <input  type="hidden" name="val" value="<?php echo $cat_id;?>"name="val">
                                <input type="submit" name="delete-cat" value="Delete" class="btn btn-link"/>
                          </form>               
                      </td>
                        </tr>
                    <?php }
                ?>
                          <?php

                              //delect categories code

                                if(isset($_POST['delete-cat'])){
                                $cid=$_POST['val'];
                                $delete="DELETE FROM categories WHERE cat_id=:cid";
                                $stmt3=$pdo->prepare($delete);
                                $stmt3->execute([':cid'=>$cid]);
                                header("location: categories.php");
                                }

                                ?>
                </tbody>
            </table>
        </section>

    </div>

<?php require_once('./include/footer.php'); ?>