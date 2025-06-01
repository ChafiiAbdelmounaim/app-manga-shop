<?php 

include 'components/connect.php' ;

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else {
    $user_id = '';
};

if (isset($_POST['send'])) {
    
    $name = filter_var($_POST['user'],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $number = filter_var($_POST['number'],FILTER_SANITIZE_STRING);
    $msg = filter_var($_POST['msg'],FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM messages WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name,$email,$number,$msg]);

    if ($select_message->rowCount() > 0) {
        $message[] = 'Message already sent !';
    }else {
        $insert_message = $conn->prepare("INSERT INTO messages (name, email, number, message) VALUES (?, ?, ?, ?)");
        $insert_message->execute([$name,$email,$number,$msg]);
        $message[] = 'thank you for your feedback !';
    }

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
    

<section class="contact">

    <form action="" method="post">
        <h3>get in touch</h3>
        <input type="text" name='user' maxlength='20' placeholder='enter your username' class='box' required >
        <input type="email" name='email' maxlength='20' placeholder='enter your email' class='box' required >
        <input type="number" name='number' maxlength='20' placeholder='enter your number' class='box' required >
        <textarea name="msg" class="box" cols="30" rows="10" placeholder='enter your message' required></textarea>
        <input type="submit" value="send message" name='send' class='btn'>
    </form>

</section>



<?php include 'components/footer.php'; ?>

<!-- custom js file link -->
<script src="js/script.js" ></script>

</body>
</html>