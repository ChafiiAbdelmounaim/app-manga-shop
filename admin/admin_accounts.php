<?php  

include '../components/connect.php' ;

session_start();
$admin_id = $_SESSION['admin_id'] ;

if (!isset($admin_id)) {
    header('location:admin_login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>admin accounts</title>

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
    <h1 class="heading">admins accounts</h1>
    <div class="box-container">

    <?php 
    $select_admins = $conn->prepare("SELECT * FROM admins");
    $select_admins->execute();
    if ($select_admins->rowCount() > 0) {
        while ($row = $select_admins->fetch(PDO::FETCH_ASSOC) ) {
    ?>
    
    <div class="box">
        <p> admin id : <span><?= $row['id']; ?></span> </p>
        <p> username : <span><?= $row['name']; ?></span> </p>
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