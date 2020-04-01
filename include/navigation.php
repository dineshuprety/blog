<a class="navbar-brand" href="index.php" style="font-size: 22px">Blog</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    
<ul class="navbar-nav mr-auto">
    <?php 

        $select = "SELECT * FROM categories";
        $stmt = $pdo->prepare($select);
        $stmt->execute();
        while($cat = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cat_id = $cat['cat_id'];
            $cat_title = $cat['cat_title']; ?>
            <li class="nav-item ">
                <a class="nav-link" href="categories.php?id=<?php echo $cat_id;?>"><?php echo $cat_title; ?></a>
            </li>
        <?php }
    
    ?>

</ul>


<form class="form-inline my-2 my-lg-0" method="POST" action="search.php">
    <input name="val" class="form-control mr-sm-2" style="font-size: 14px" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>
    
</div>