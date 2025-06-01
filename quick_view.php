<?php 

include 'components/connect.php' ;

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else {
    $user_id = '';
}

include 'components/add_to_cart.php';

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
    

<section class="quick-view">

    <h3 class="heading">quick view</h3>

    <?php 
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $select_products->execute([$pid]);
            if ($select_products->rowCount() > 0) {
                while ($row = $select_products->fetch(PDO::FETCH_ASSOC) ) {
            ?>
            
            <form action="" method="post" class="box" >
                <div class="row">
                    <input type="hidden" name="pid" value="<?= $row['id']; ?>" >
                    <input type="hidden" name="name" value="<?= $row['name']; ?>" >
                    <input type="hidden" name="price" value="<?= $row['price']; ?>" >
                    <input type="hidden" name="image" value="<?= $row['image_01']; ?>" >
                    <div class="image-container">
                        <div class="main-image">
                            <img src="uploaded_img/<?= $row['image_01']; ?>" alt="">
                        </div>
                        <div class="sub-image">
                        <img src="uploaded_img/<?= $row['image_01']; ?>" alt="">
                            <img src="uploaded_img/<?= $row['image_02']; ?>" alt="">
                            <img src="uploaded_img/<?= $row['image_03']; ?>" alt="">
                        </div>
                    </div>

                    <div class="content">
                        <div class="name"><?= $row['name']; ?></div>
                            <div class="price"><?= $row['price']; ?> MAD</div>
                            <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length > 2 ) return false;" >
                        <div class="details"><?= $row['details']; ?></div>
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn" >
                    </div>
                </div>
            </form>
            
        <?php
            }
        }else {
            echo '<p class="empty" >no products added yet !</p>';
        }
        ?>

</section>


<?php include 'components/footer.php'; ?>

<!-- custom js file link -->
<script src="js/script.js" ></script>

</body>
</html>