<?php  

include '../components/connect.php' ;

session_start();
$admin_id = $_SESSION['admin_id'] ;

if (!isset($admin_id)) {
    header('location:admin_login.php');
};

if (isset($_GET['delete'])) {
    
    $user_id = $_GET['delete'];

    $delete_user = $conn->prepare("DELETE FROM users WHERE id = :uid");
    $delete_user->bindParam(":uid",$user_id);
    $delete_user->execute();

    $delete_order = $conn->prepare("DELETE FROM orders WHERE user_id = :uid");
    $delete_order->bindParam(":uid",$user_id);
    $delete_order->execute();

    $delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = :uid");
    $delete_cart->bindParam(":uid",$user_id);
    $delete_cart->execute();

    $message[] = 'user deleted successfully !' ;

    //  Insert Log

    $t = date("Y-m-d H:i:s",time());

    $insert_log = $conn->prepare("INSERT INTO adminactionslog (admin_id, entity_type, entity_id, action_type, action_timestamp )
    VALUES (:admin_id, :entity_type, :entity_id, :action_type, :action_timestamp )");
    $insert_log->bindParam(":admin_id",$admin_id);
    $insert_log->bindParam(":entity_type",$entity_type[2]);
    $insert_log->bindParam(":entity_id",$user_id);
    $insert_log->bindParam(":action_type",$action_type[2]);
    $insert_log->bindParam(":action_timestamp",$t);
    $insert_log->execute();


    
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>user accounts</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<?php

if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="message">
        <span>'.$message.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();" ></i>
    </div>' ;
    }
}

?>

<?php 
include '../components/admin_header.php' ;
?>

<section class="accounts" >
    <h1 class="heading">users accounts</h1>
    <div class="box-container">

    <?php 
    $select_users = $conn->prepare("SELECT * FROM users");
    $select_users->execute();
    if ($select_users->rowCount() > 0) {
        while ($row = $select_users->fetch(PDO::FETCH_ASSOC) ) {
    ?>
    
    <div class="box">
        <p> user id : <span><?= $row['id']; ?></span> </p>
        <p> username : <span><?= $row['name']; ?></span> </p>
        <div class="flex-btn">
            <a href="users_accounts.php?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('delete this user ?');" >delete</a>
        </div>
    </div>

    <?php
        }
    }else {
        echo '<p class="empty" >no accounts available !</p>';
    }
    ?>


    </div>
</section>


<!-- custom js file link -->
<script src="../js/admin_script.js" ></script>

</body>
</html>