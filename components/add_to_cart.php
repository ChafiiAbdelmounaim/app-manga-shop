<?php 

if (isset($_POST['add_to_cart'])) {
    
    if ( $user_id == '' ) {
        header("location:user_login.php");
    }else {
        
        $pid = $_POST['pid'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['qty'];
        $image = $_POST['image'];

        $select_cart = $conn->prepare("SELECT * FROM cart WHERE pid=:pid AND user_id=:uid ");
        $select_cart->bindParam(":pid",$pid);
        $select_cart->bindParam(":uid",$user_id);
        $select_cart->execute();

        if ( $select_cart->rowCount() > 0 ) {
            $message[] = 'product already in cart !';
        }else {
            $add_to_cart = $conn->prepare("INSERT INTO cart (user_id,pid,name,price,quantity,image) VALUES (:uid,:pid,:name,:price,:qty,:image)");
            $add_to_cart->bindParam(":uid",$user_id);
            $add_to_cart->bindParam(":pid",$pid);
            $add_to_cart->bindParam(":name",$name);
            $add_to_cart->bindParam(":price",$price);
            $add_to_cart->bindParam(":qty",$quantity);
            $add_to_cart->bindParam(":image",$image);
            $add_to_cart->execute();

            $message[] = 'product added to cart !';


        }

    }


}

?>