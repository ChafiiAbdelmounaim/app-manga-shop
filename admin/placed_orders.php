<?php  

include '../components/connect.php' ;

session_start();
$admin_id = $_SESSION['admin_id'] ;

if (!isset($admin_id)) {
    header('location:admin_login.php');
};

if (isset($_POST['update_payment'])) {
    
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $update_payment_status = $conn->prepare("UPDATE orders SET payment_status = :ps WHERE id = :oid");
    $update_payment_status->bindParam(":oid",$order_id);
    $update_payment_status->bindParam(":ps",$payment_status);
    $update_payment_status->execute();
    $message[] = 'payment status successfully updated !';

    //  Insert Log

    $t = date("Y-m-d H:i:s",time());

    $insert_log = $conn->prepare("INSERT INTO adminactionslog (admin_id, entity_type, entity_id, action_type, action_timestamp )
    VALUES (:admin_id, :entity_type, :entity_id, :action_type, :action_timestamp )");
    $insert_log->bindParam(":admin_id",$admin_id);
    $insert_log->bindParam(":entity_type",$entity_type[1]);
    $insert_log->bindParam(":entity_id",$order_id);
    $insert_log->bindParam(":action_type",$action_type[1]);
    $insert_log->bindParam(":action_timestamp",$t);
    $insert_log->execute();

};

if (isset($_GET['delete'])) {
    
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM orders WHERE id = :oid");
    $delete_order->bindParam(":oid",$delete_id);
    $delete_order->execute();

    //  Insert Log

    $t = date("Y-m-d H:i:s",time());

    $insert_log = $conn->prepare("INSERT INTO adminactionslog (admin_id, entity_type, entity_id, action_type, action_timestamp )
    VALUES (:admin_id, :entity_type, :entity_id, :action_type, :action_timestamp )");
    $insert_log->bindParam(":admin_id",$admin_id);
    $insert_log->bindParam(":entity_type",$entity_type[1]);
    $insert_log->bindParam(":entity_id",$order_id);
    $insert_log->bindParam(":action_type",$action_type[2]);
    $insert_log->bindParam(":action_timestamp",$t);
    $insert_log->execute();
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>orders</title>

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

<section class="orders">
    <h3 class="heading">placed orders</h3>
    <div class="box-container">

    <?php 
    $select_orders = $conn->prepare("SELECT * FROM orders");
    $select_orders->execute();
    if ($select_orders->rowCount() > 0) {
        while ($row = $select_orders->fetch(PDO::FETCH_ASSOC) ) {
    ?>
    
    <div class="box">
        <p> user id <span><?= $row['user_id']; ?></span> </p>
        <p> placed on <span><?= $row['placed_on']; ?></span> </p>
        <p> name <span><?= $row['name']; ?></span> </p>
        <p> email <span><?= $row['email']; ?></span> </p>
        <p> number <span><?= $row['number']; ?></span> </p>
        <p> address <span><?= $row['address']; ?></span> </p>
        <p> total products <span><?= $row['total_products']; ?></span> </p>
        <p> total price <span><?= $row['total_price']; ?></span> </p>
        <p> payment method <span><?= $row['method']; ?></span> </p>
        <form action="" method="post">
            <input type="hidden" name="order_id" value="<?= $row['id']; ?>" >
            <select name="payment_status" class="select">
                <option value="" selected disabled ><?= $row['payment_status']; ?></option>
                <option value="pending">pending</option>
                <option value="completed">completed</option>
            </select>
            <div class="flex-btn">
                <input type="submit" value="update" class="btn" name="update_payment" >
                <a href="placed_orders.php?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('delete this order ?');" >delete</a>
            </div>
        </form>
    </div>

    <?php
        }
    }else {
        echo '<p class="empty" >no orders placed yet !</p>';
    }
    ?>

    </div>

</section>


<!-- custom js file link -->
<script src="../js/admin_script.js" ></script>

</body>
</html>