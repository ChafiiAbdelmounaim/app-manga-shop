<?php

require('./fpdf186/fpdf.php');
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      // Generate PDF using FPDF
      $pdf = new FPDF();
      $pdf->AddPage();

      // Set title
      $pdf->SetFont('Arial', 'B', 16);
      $pdf->Cell(190, 10, 'Order Confirmation', 0, 1, 'C'); // Center title
      $pdf->Ln(10);

      // Customer information
      $pdf->SetFont('Arial', '', 12);
      $pdf->Cell(40, 10, 'Name: ' . $name);
      $pdf->Ln(7);
      $pdf->Cell(40, 10, 'Phone Number: ' . $number);
      $pdf->Ln(7);
      $pdf->Cell(40, 10, 'Email: ' . $email);
      $pdf->Ln(7);
      $pdf->Cell(40, 10, 'Payment Method: ' . $method);
      $pdf->Ln(7);

      // Address (split into multiple lines)
      $pdf->Ln(5);
      $pdf->SetFont('Arial', 'B', 12);
      $pdf->Cell(40, 10, 'Shipping Address:');
      $pdf->SetFont('Arial', '', 12);
      $pdf->Ln(7);
      $pdf->MultiCell(0, 10, $_POST['flat'] . "\n" . $_POST['street'] . "\n" . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . "\n Zip Code : " . $_POST['pin_code']);
      $pdf->Ln(10);

      // Order Items
      $pdf->SetFont('Arial', 'B', 12);
      $pdf->Cell(190, 10, 'Order Items', 0, 1, 'C');
      $pdf->Ln(5);

      // Table header
      $pdf->SetFont('Arial', 'B', 12);
      $pdf->Cell(90, 10, 'Item', 1);
      $pdf->Cell(30, 10, 'Quantity', 1);
      $pdf->Cell(40, 10, 'Price (MAD)', 1);
      $pdf->Ln();

      // Table rows for cart items
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(90, 10, $fetch_cart['name'], 1);
            $pdf->Cell(30, 10, $fetch_cart['quantity'], 1, 0, 'C');
            $pdf->Cell(40, 10, $fetch_cart['price'], 1, 0, 'R');
            $pdf->Ln();
         }
      }

      // Total Price
      $pdf->SetFont('Arial', 'B', 12);
      $pdf->Cell(120, 10, 'Total Price:', 1);
      $pdf->Cell(40, 10, $total_price . ' MAD', 1, 0, 'R');
      $pdf->Ln(10);

      // Output the PDF to browser (inline or download)
      $pdf->Output('I', 'order_confirmation.pdf');

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);


      $message[] = 'order placed successfully!';
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= $fetch_cart['price'].'MAD x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">grand total : <span><?= $grand_total; ?> MAD</span></div>
      </div>

      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paytm">paytm</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. house number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>address line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. Casablanca" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. Casa-Sttat" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. Morocco" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
   
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>