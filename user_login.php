<?php 

include 'components/connect.php' ;

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else {
    $user_id = '';
};

if (isset($_POST['submit'])) {
    
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $password = md5(filter_var($_POST['pwd'],FILTER_SANITIZE_STRING));

    $select_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $select_user->execute([$email,$password]);

    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $_SESSION['user_id'] = $row['id'] ;
        header('location:home.php');
    }else {
        $message[] = 'incorrect email or password !';
    }

};

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

<section class="form-container">

    <form action="" method="post" >
        <h3 class="heading">login now</h3>
        <input type="email" name="email" placeholder="enter your email" class="box" required >
        <input type="password" name="pwd" placeholder="enter your password" class="box" required >
        <input type="submit" value="login now" name="submit" class="btn" >
        <p>don't have an account ?</p>
        <a href="user_register.php" class="option-btn" >register now</a>
    </form>

</section>

<?php include 'components/footer.php'; ?>

</body>
</html>