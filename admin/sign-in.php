<?php require_once('./include/header.php');?>
    <div class="container">
        <h2 class="text-uppercase mt-5 sign-in" style="text-align:center">Sign In</h2>
        <?php

            if(isset($_POST['submit'])){
                $user_name=trim($_POST['user-name']);
                $user_email=trim($_POST['user-email']);
                $user_password=trim($_POST['user-password']);
                if(empty($user_name)||empty($user_email)||empty($user_password)){
                    echo '<div class="alert alert-danger"> Field cant be empty </div>';
                }else{
                    $select ="SELECT * FROM users";
                    $stmt=$pdo->prepare($select);
                    $stmt->execute();
                    while($user=$stmt->fetch(PDO::FETCH_ASSOC)){
                        $name=$user['user_name'];
                        $email=$user['user_email'];
                        $password=$user['user_password'];
                        if($user_name==$name && $user_email==$email && $user_password==$password){
                            echo"<div class='alert alert-danger'> Login....</div>";
                            setcookie('_ua_',md5(1),time() + 86400 * 30,'','','',true);
                            header('refresh:2;index.php');
                        }else{
                            echo"<div class='alert alert-danger'> Wrong Credintials</div>";
                        }
                    }
                }
            }
        
        ?>

        <form class="py-2 d-flex justify-content-center flex-column" method="POST" action="">
            <div class="form-group m-3">
                <label for="username">Username</label>
                <input name="user-name" type="text" class="form-control" id="username" placeholder="Enter Username">
            </div>
            <div class="form-group m-3">
                <label for="email">Email address</label>
                <input name="user-email" type="email" class="form-control" id="email" placeholder="Enter Email Address">
            </div>
            <div class="form-group m-3">
                <label for="password">Password</label>
                <input name="user-password" type="password" class="form-control" id="password" placeholder="Enter Password">
            </div>
            <button name="submit" type="submit" class="btn btn-primary m-3 align-self-end">SIGN IN</button>
        </form>
    </div>
    <?php require_once('./include/footer.php');?>