<?php 

if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="message">
        <span>'.$message.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();" ></i>
    </div>' ;
    }
};

?>

<header class="header" >

    <section class="flex">

        <a href="home.php" class="logo">Manga<span>shop</span></a>

        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="orders.php">orders</a>
            <a href="shop.php">shop</a>
            <a href="contact.php">contact</a>
        </nav>

        <div class="icons">
            <?php 
            
            $count_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ? ");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
            
            ?>
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php"><i class="fas fa-search" ></i></a>
            <a href="cart.php"><i class="fas fa-shopping-cart" ></i><span>(<?= $total_cart_items; ?>)</span></a>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="profile">
            <?php 
            $select_profile = $conn->prepare("SELECT * FROM users WHERE id = :uid");
            $select_profile->bindParam(':uid',$user_id);
            $select_profile->execute();

            if ($select_profile->rowCount() > 0 ) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            
            ?>

            <p><?= $fetch_profile['name']; ?></p>
            <a href="update_user.php" class="btn" >update</a>
            <div class="flex">
                <a href="user_login.php" class="option-btn" >login</a>
                <a href="user_register.php" class="option-btn" >register</a>
            </div>
            <a href="./components/user_logout.php" class="delete-btn" >logout</a>

            <?php }else {
            ?>
                <p>please login first !</p>
                <div class="flex">
                <a href="user_login.php" class="option-btn" >login</a>
                <a href="user_register.php" class="option-btn" >register</a>
            </div>
            <?php 
            } ?>
        </div>

    </section>


</header>