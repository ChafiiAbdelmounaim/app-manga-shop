<?php 

include 'components/connect.php' ;

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else {
    $user_id = '';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php' ; ?>
    



<section class="about">
    <div class="row">
        <div class="image">
            <img src="images/contact.svg" alt="">
        </div>
        <div class="content">
            <h3>why choose us ?</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptates ipsum dolore quaerat, adipisci nihil recusandae quae officia veritatis, officiis voluptatibus exercitationem sed atque culpa neque. Necessitatibus velit fuga vitae perferendis!</p>
            <a href="contact.php" class="btn" >contact us</a>
        </div>
    </div>

    <div class="row">
        <div class="image">
            <img src="images/shop.svg" alt="">
        </div>
        <div class="content">
            <h3>what we provide ?</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptates ipsum dolore quaerat, adipisci nihil recusandae quae officia veritatis, officiis voluptatibus exercitationem sed atque culpa neque. Necessitatibus velit fuga vitae perferendis!</p>
            <a href="shop.php" class="btn" >shop now</a>
        </div>
    </div>
</section>




<?php include 'components/footer.php'; ?>

<!-- custom js file link -->
<script src="js/script.js" ></script>

</body>
</html>