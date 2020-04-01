<?php require_once('./include/header.php');?>


    <div class="fluid-container">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-md-5 p-3">

        <?php require_once ('./include/navigation.php');?>
        
      </nav> <!--End nav-->

      <section id="main">
        <div class="post-single-information">  

        <?php

          if(isset($_GET['id'])){
            $id =$_GET['id'];
            $select="SELECT * FROM post WHERE post_id =:id";
            $stmt=$pdo->prepare($select);
            $stmt->execute([':id'=>$id]);
            $count =$stmt->rowCount();
            if($count==1){
                while($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $post_title = $post['post_title'];
                $post_des = $post['post_des'];
                $post_image = $post['post_image'];
                $post_cat_id = $post['post_cat_id'];
                $post_date = $post['post_date'];
                $post_author = $post['post_author']; ?>   

                <div class="post-single-info">
              <div class="post-single-80">                 
                  <h1 class="category-title">Category: 

                    <?php
                        $select1 = "SELECT * FROM categories WHERE cat_id = :cat_id";
                        $stmt1 = $pdo->prepare($select1);
                        $stmt1->execute([':cat_id'=>$post_cat_id]);
                        while($cat = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                          $cat_title = $cat['cat_title'];
                        }
                        echo $cat_title;
                    ?>

                  </h1>
                  <h2 class="post-single-title">Title: <?php echo $post_title;?></h2>
                  <div class="post-single-box">
                      Posted by <?php echo $post_author;?> at <?php echo $post_date;?>
                  </div>
              </div>
          </div>
          <div class="post-main">
            <img class="d-block" style="width:100%;height:400px;" src="./img/<?php echo $post_image;?>" alt="photo" />
            <p class="mt-4" style="color:black;">
              
              <?php echo $post_des;?>

            </p>
          </div>
        </div>
        <?php } 
        }
        else{
          echo "<p class='alert alert-danger'> No Page found!</p>";
      }
    }
        ?>     
          



        <div class="comments">

          <?php

              $select2="SELECT * FROM comments WHERE comment_post_id =:id";
              $stmt2=$pdo->prepare($select2);
              $stmt2->execute([':id'=>$_GET['id']]);
              $comment_count=$stmt2->rowCount();
              if($comment_count==0){
                echo"No comments";
              }else{
                echo '<h2 class="comment-count">'.$comment_count.' Comments</h2> ';
                while($comment=$stmt2->fetch(PDO::FETCH_ASSOC)){
                  $comment_author=$comment['comment_author'];
                  $comment_des=$comment['comment_des'];
                  $comment_date=$comment['comment_date']; ?>
                    <div class="comment-box">
                        <img src="./img/js.png" style="width:88px;height:88px;border-radius:50%" alt="Author photo" class="comment-photo">
                        <div class="comment-content">
                            <span class="comment-author"><b><?php echo"$comment_author";?></b></span>
                            <span class="comment-date"><?php echo"$comment_date";?></span>
                            <p class="comment-text">
                            <?php echo"$comment_des";?>
                            </p>
                        </div>
                        </div>

                <?php }
              }
              ?>
              


          <h3 class="leave-comment">Leave a comment</h3>
              <?php
              
              if(isset($_POST['submit-comment'])){
                $name=trim($_POST['name']);
                $comment=($_POST['comment']);
                $date=date('j F Y');
                if(empty($name)||empty($comment)){
                  echo ' <div class=" alert alert-danger"> please fill the from </div> ';
                }else{
                  $insert="INSERT INTO comments(comment_des,comment_date,comment_author,comment_post_id) VALUES (:comment,:date,:author,:cp_id)";
                  $stmt3=$pdo->prepare($insert);
                  $stmt3->execute([
                    ':comment'=>$comment,
                    ':date'=>$date,
                    ':author'=>$name,
                    ':cp_id'=>$_GET['id']
                  ]);
                  $update="UPDATE post SET post_comment=post_comment +1 WHERE post_id=:id";
                  $stmt4=$pdo->prepare($update);
                  $stmt4->execute([':id'=>$id]);
                //  header("Location: single.php?id={$id}");
                }
              }
                
              ?>
          <div class="comment-submit">
              <form action="" class="comment-form" method="POST">
                  <input name="name" class="input" type="text" placeholder="Enter Full Name">
                  <textarea name="comment" id="" cols="20" rows="5" placeholder="Comment text"></textarea>
                  <input type="submit" value="Submit" class="comment-btn" name="submit-comment">
              </form>
          </div>
        </div>
      </section>

     <?php require_once('./include/footer.php');?>