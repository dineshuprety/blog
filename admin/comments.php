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
        <div class="d-flex flex-row justify-content-between">
            <h2 class="my-3">All Comments</h2>
        </div>
        
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">User name</th>
                <th scope="col">Comment</th>
                <th scope="col" class="d-none d-md-table-cell">In response to</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php
              $select = "SELECT * FROM comments WHERE comment_post_id = :id";
              $stmt = $pdo->prepare($select);
              $stmt->execute([
                ':id' => $_GET['id']
              ]);
              $count = $stmt->rowCount();
              if($count == 0) {
                echo "No comments";
                exit;
              }
              while($com = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $c_id = $com['comment_id'];
                $c_content = $com['comment_des'];
                $c_author = $com['comment_author']; ?>
                  <tr>
                      <td><?php echo $c_id; ?></td>
                      <td><?php echo $c_author; ?></td>
                      <td><?php echo $c_content; ?></td>
                      <td class="d-none d-md-table-cell">
                          <a href="../single.php?id=<?php echo $_GET['id']; ?>">
                          <?php 
                            $select1 = "SELECT * FROM post WHERE post_id = :id";
                            $stmt1 = $pdo->prepare($select1);
                            $stmt1->execute([
                              ':id'=> $_GET['id']
                            ]);
                            while($post = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                              $post_title = $post['post_title'];
                            }
                            echo $post_title;
                          ?>
                          </a>
                      </td>
                      <td>
                          <form action="comments.php?id=<?php echo $_GET['id']; ?>" method="POST">
                              <input type="hidden" value="<?php echo $c_id; ?>" name="val" />
                              <input class="btn btn-link" type="submit" value="Delete" name="delete" />
                          </form>               
                      </td>
                  </tr>
              <?php }
            ?>
                
            </tbody>
        </table>

        <?php
            if(isset($_POST['delete'])) {
              $cid = $_POST['val'];
              echo $cid;
              // delete the comments in comments table
              $delete = "DELETE FROM comments WHERE comment_id = :id";
              $stmt2 = $pdo->prepare($delete);
              $stmt2->execute(
                [
                  ':id' => $cid
                ]
                );
                // update post_comment in post table
                $update = "UPDATE post SET post_comment = post_comment - 1 WHERE post_id = :pid";
                $stmt4 = $pdo->prepare($update);
                $stmt4->execute([
                  ':pid' => $_GET['id']
                ]);
                header("Location: comments.php?id={$_GET['id']}");
              
            }
        ?>
    
      </section>


    </div>

<?php require_once('./include/footer.php'); ?>