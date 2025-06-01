<?php  

include '../components/connect.php' ;

session_start();

if (isset($_POST['submit'])) {
    
    $name = filter_var($_POST['user'],FILTER_SANITIZE_STRING);
    $pwd = md5(filter_var($_POST['pwd'],FILTER_SANITIZE_STRING));

    $select_admin = $conn->prepare("SELECT * FROM admins WHERE name=:name AND password = :password");
    $select_admin->bindParam(':name',$name);
    $select_admin->bindParam(':password',$pwd);
    $select_admin->execute();

    if ($select_admin->rowCount() > 0 ) {
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location:dashboard.php');
    }else {
        $message[] = 'incorrect username or password !';
    }

};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>login</title>

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

<section class='form-container' >
    <form action="" method='post'>
        <h3>login now</h3>
        <p>Welcome To <span>Admin</span> Space !</p>
        <input type="text" name='user' maxlength='20' placeholder='enter your username' class='box' required >
        <input type="password" name='pwd' maxlength='20' placeholder='enter your password' class='box' required >
        <input type="submit" value="login now" name='submit' class='btn'>
    </form>
</section>


</body>
</html>