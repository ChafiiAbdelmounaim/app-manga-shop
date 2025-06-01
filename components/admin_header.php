<header class="header" >

    <section class="flex">

        <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

        <nav class="navbar">
            <a href="dashboard.php">home</a>
            <a href="products.php">products</a>
            <a href="placed_orders.php">orders</a>
            <a href="admin_accounts.php">admins</a>
            <a href="users_accounts.php">users</a>
            <a href="messages.php">messages</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="profile">
            <?php 
            $select_profile = $conn->prepare("SELECT * FROM admins WHERE id = :aid");
            $select_profile->bindParam(':aid',$admin_id);
            $select_profile->execute();

            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>

            <p><?= $fetch_profile['name']; ?></p>
            <a href="update_profile.php" class="btn" >update</a>
            <div class="flex">
                <a href="admin_login.php" class="option-btn" >login</a>
                <a href="register_admin.php" class="option-btn" >register</a>
            </div>
            <a href="../components/admin_logout.php" class="delete-btn" >logout</a>
        </div>

    </section>

</header>