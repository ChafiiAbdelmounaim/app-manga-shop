<?php 

include 'components/connect.php' ;

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else {
    $user_id = '';
};

if (isset($_POST['submit'])) {
    
    $name = filter_var($_POST['user'],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $pass = md5(filter_var($_POST['pwd'],FILTER_SANITIZE_STRING));
    $cpass = md5(filter_var($_POST['cpwd'],FILTER_SANITIZE_STRING));

    $select_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $select_user->execute([$email]);

    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $message[] = 'user already exist !';
    }elseif ($pass != $cpass) {
        $message[] = 'confirm password not matched !';
    }else {
        $insert_user = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
        $insert_user->execute([$name, $email, $pass]);
        $message[] = 'user registerd successfully !';
        header("location:user_login.php");
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

    <form action="" method='post'>
        <h3>register now</h3>
        <input type="text" name='user' maxlength='20' placeholder='enter your username' class='box' required >
        <input type="email" name='email' maxlength='20' placeholder='enter your email' class='box' required >
        <input type="password" name='pwd' maxlength='20' placeholder='enter your password' class='box' required >
        <input type="password" name='cpwd' maxlength='20' placeholder='confirme your password' class='box' required >
        <input type="submit" value="register now" name='submit' class='btn'>
        <p>already have an account ?</p>
        <a href="user_login.php" class="option-btn" >login now</a>
    </form>

</section>

<?php include 'components/footer.php'; ?>

</body>
</html>