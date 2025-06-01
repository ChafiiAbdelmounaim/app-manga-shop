<?php  

include '../components/connect.php' ;

session_start();
$admin_id = $_SESSION['admin_id'] ;

if (!isset($admin_id)) {
    header('location:admin_login.php');
};

if (isset($_GET['delete'])) {
    
    $message_id = $_GET['delete'];

    $delete_message = $conn->prepare("DELETE FROM messages WHERE id = :mid");
    $delete_message->bindParam(":mid",$message_id);
    $delete_message->execute();
    $message[] = 'message deleted successfully !' ;


    
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>messages</title>

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

<section class="contacts">

    <h1 class="heading">messages</h1>

    <div class="box-container">

    <?php 
    
    $select_messages = $conn->prepare("SELECT * FROM messages");
    $select_messages->execute();
    if ( $select_messages->rowCount() > 0) {
        while ($row = $select_messages->fetch(PDO::FETCH_ASSOC)) {
    ?>

            <div class="box">
                <p> user id : <span><?= $row['user_id']; ?></span></p>
                <p> name : <span><?= $row['name']; ?></span></p>
                <p> number : <span><?= $row['number']; ?></span></p>
                <p> email : <span><?= $row['email']; ?></span></p>
                <p> message : <span><?= $row['message']; ?></span></p>
                <a href="messages.php?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('delete this message ?');">delete</a>
            </div>

    <?php
        }
    }else {
        echo '<p class="empty" >you have no message !</p>' ;
    }
    
    ?>

    </div>

</section>


<!-- custom js file link -->
<script src="../js/admin_script.js" ></script>

</body>
</html>