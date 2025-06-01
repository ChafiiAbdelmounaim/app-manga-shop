<?php  

include '../components/connect.php' ;

session_start();
$admin_id = $_SESSION['admin_id'] ;

if (!isset($admin_id)) {
    header('location:admin_login.php');
};

if (isset($_POST['submit'])) {

    $pid = $_POST['pid'];
    // define name & price & details
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING) ;
    $price = filter_var($_POST['price'],FILTER_SANITIZE_STRING) ;
    $details = filter_var($_POST['details'],FILTER_SANITIZE_STRING) ;

    $update_product = $conn->prepare("UPDATE products SET name = :name ,details=:details, price= :price WHERE id = :pid");
    $update_product->bindParam(":pid",$pid);
    $update_product->bindParam(":name",$name);
    $update_product->bindParam(":details",$details);
    $update_product->bindParam(":price",$price);
    $update_product->execute();
    $message[] = 'product updated successfully !';

    $old_img_01 = $_POST['old_img_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01,FILTER_SANITIZE_STRING);
    $image_01_size = $_FILES['image_01']['size'];
    $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_01_path = '../uploaded_img/'.$image_01 ;

    if (!empty($image_01)) {
        if ($image_01_size > 2000000) {
            $message[] = 'image is too large !';
        }else {
            $update_img_01 = $conn->prepare("UPDATE products SET image_01 = :img1 WHERE id = :pid");
            $update_img_01->bindParam(":pid",$pid);
            $update_img_01->bindParam(":img1",$image_01);
            $update_img_01->execute();
            move_uploaded_file($image_01_tmp_name,$image_01_path);
            unlink('../uploaded_img/'.$old_img_01);
            $message[] = 'image 01 updated !';
        }
    }

    $old_img_02 = $_POST['old_img_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02,FILTER_SANITIZE_STRING);
    $image_02_size = $_FILES['image_02']['size'];
    $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
    $image_02_path = '../uploaded_img/'.$image_02 ;

    if (!empty($image_02)) {
        if ($image_02_size > 2000000) {
            $message[] = 'image is too large !';
        }else {
            $update_img_02 = $conn->prepare("UPDATE products SET image_02 = :img2 WHERE id = :pid");
            $update_img_02->bindParam(":pid",$pid);
            $update_img_02->bindParam(":img2",$image_02);
            $update_img_02->execute();
            move_uploaded_file($image_02_tmp_name,$image_02_path);
            unlink('../uploaded_img/'.$old_img_02);
            $message[] = 'image 02 updated !';
        }
    }

    $old_img_03 = $_POST['old_img_03'];
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03,FILTER_SANITIZE_STRING);
    $image_03_size = $_FILES['image_03']['size'];
    $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
    $image_03_path = '../uploaded_img/'.$image_03 ;

    if (!empty($image_03)) {
        if ($image_03_size > 2000000) {
            $message[] = 'image is too large !';
        }else {
            $update_img_03 = $conn->prepare("UPDATE products SET image_03 = :img3 WHERE id = :pid");
            $update_img_03->bindParam(":pid",$pid);
            $update_img_03->bindParam(":img3",$image_03);
            $update_img_03->execute();
            move_uploaded_file($image_03_tmp_name,$image_03_path);
            unlink('../uploaded_img/'.$old_img_03);
            $message[] = 'image 03 updated !';
        }
    }

    //  Insert Log

    $t = date("Y-m-d H:i:s",time());

    $insert_log = $conn->prepare("INSERT INTO adminactionslog (admin_id, entity_type, entity_id, action_type, action_timestamp )
    VALUES (:admin_id, :entity_type, :entity_id, :action_type, :action_timestamp )");
    $insert_log->bindParam(":admin_id",$admin_id);
    $insert_log->bindParam(":entity_type",$entity_type[0]);
    $insert_log->bindParam(":entity_id",$pid);
    $insert_log->bindParam(":action_type",$action_type[1]);
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
    <title>product update</title>

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

<section class="update-product">
<h1 class="heading">update product</h1>
<?php 

    $update_id = $_GET['update'];
    $select_product = $conn->prepare("SELECT * FROM products WHERE id = :uid");
    $select_product->bindParam(":uid",$update_id);
    $select_product->execute();
    if ($select_product->rowCount() > 0) {
        while ($row = $select_product->fetch(PDO::FETCH_ASSOC) ) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="image-container">
            <div class="main-image">
                <img src="../uploaded_img/<?= $row['image_01']; ?>" alt="">
            </div>
            <div class="sub-image">
                <img src="../uploaded_img/<?= $row['image_01']; ?>" alt="">
                <img src="../uploaded_img/<?= $row['image_02']; ?>" alt="">
                <img src="../uploaded_img/<?= $row['image_03']; ?>" alt="">
            </div>
        </div>
        <input type="hidden" name="pid" value="<?= $row['id']; ?>">
        <input type="hidden" name="old_img_01" value="<?= $row['image_01']; ?>" >
        <input type="hidden" name="old_img_02" value="<?= $row['image_02']; ?>" >
        <input type="hidden" name="old_img_03" value="<?= $row['image_03']; ?>" >
        <input type="text" placeholder="enter product name" name="name" value="<?= $row['name']; ?>" maxlength="100" class="box" required >
        <input type="number" placeholder="enter product price" name="price" value="<?= $row['price']; ?>" maxlength="100" class="box" required >
        <textarea name="details"  placeholder="enter product details" cols="15" rows="5" class="box" required><?= $row['details']; ?></textarea>
        <input type="file" name="image_01" accept="image/jpg,image/jpeg,image/png,image/webp" class="box"  >
        <input type="file" name="image_02" accept="image/jpg,image/jpeg,image/png,image/webp" class="box" >
        <input type="file" name="image_03" accept="image/jpg,image/jpeg,image/png,image/webp" class="box"  >
        <div class="flex-btn">
            <input type="submit" name="submit" value="update" class="btn">
            <a href="products.php" class="option-btn" >go back</a>
        </div>
    </form>
    <?php
        }
    }else {
        echo '<p class="empty" >no products added yet !</p>';
    }
    ?>

</section>


<!-- javascript -->

<script>

let mainImage = document.querySelector('.update-product .image-container .main-image img');
let subImages = document.querySelectorAll('.update-product .image-container .sub-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});

</script>

</body>
</html>