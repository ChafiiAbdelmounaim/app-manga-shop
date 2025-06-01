<?php 

include 'components/connect.php' ;

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else {
    $user_id = '';
};

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

    <!-- swiperjs cdn link -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php' ; ?>
    

<div class="home-bg">

    <section class="swiper home">

        <div class="swiper-wrapper">

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/image-01.png" >
                </div>
                <div class="content">
                    <span>upto 50% off</span>
                    <h3>huge discounts</h3>
                    <a href="shop.php" class="btn" >shop now</a>
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/image-02.png" >
                </div>
                <div class="content">
                    <span>upto 50% off</span>
                    <h3>various manga</h3>
                    <a href="shop.php" class="btn" >shop now</a>
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/image-03.png">
                </div>
                <div class="content">
                    <span>upto 50% off</span>
                    <h3>latest volumes</h3>
                    <a href="shop.php" class="btn" >shop now</a>
                </div>
            </div>

        </div>

        <div class="swiper-pagination"></div>

    </section>

</div>

<section class="home-products">
    <h3 class="heading">latest products</h3>

    <div class="box-container">
        <?php 
            $select_products = $conn->prepare("SELECT * FROM products LIMIT 6");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
                while ($row = $select_products->fetch(PDO::FETCH_ASSOC) ) {
            ?>
            
            <form action="" method="post" class="box" >
                <input type="hidden" name="pid" value="<?= $row['id']; ?>" >
                <input type="hidden" name="name" value="<?= $row['name']; ?>" >
                <input type="hidden" name="price" value="<?= $row['price']; ?>" >
                <input type="hidden" name="image" value="<?= $row['image_01']; ?>" >
                <div class="container">
                    <img src="uploaded_img/<?= $row['image_01']; ?>" class="image">
                    <a class="overlay" href="quick_view.php?pid=<?= $row['id']; ?>">
                        <div class="content">
                            <i class="fas fa-eye"></i>
                            <p>see product</p>
                        </div>
                    </a>
                </div>
                <div class="name"><?= $row['name']; ?></div>
                <div class="price"><?= $row['price']; ?> MAD</div>
                <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length > 2 ) return false;" >
                <input type="submit" value="add to cart" name="add_to_cart" class="btn" >
                
            </form>
            
        <?php
            }
        }else {
            echo '<p class="empty" >no products added yet !</p>';
        }
        ?>

    </div>

</section>


<?php include 'components/footer.php'; ?>

<!-- custom js file link -->
<script src="js/script.js" ></script>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".home", {
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
    },
    });
</script>

</body>
</html>