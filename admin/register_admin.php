<?php  

include '../components/connect.php' ;

session_start();
$admin_id = $_SESSION['admin_id'] ;

if (!isset($admin_id)) {
    header('location:admin_login.php');
};


if (isset($_POST['submit'])) {
    
    $name = filter_var($_POST['user'],FILTER_SANITIZE_STRING);
    $pwd = md5(filter_var($_POST['pwd'],FILTER_SANITIZE_STRING));
    $cpwd = md5(filter_var($_POST['cpwd'],FILTER_SANITIZE_STRING));

    $select_admin = $conn->prepare("SELECT * FROM admins WHERE name=:name");
    $select_admin->bindParam(':name',$name);
    $select_admin->execute();

    if ($pwd != $cpwd) {
        $message[] = 'confirm password not matched !';
    }elseif ($select_admin->rowCount() > 0) {
        $message[] = 'admin already exist !';
    }else {
        $insert_admin = $conn->prepare("INSERT INTO admins(name,password) VALUES (:name,:password)");
        $insert_admin->bindParam(":name",$name);
        $insert_admin->bindParam(":password",$pwd);
        $insert_admin->execute();
        $message[] = 'admin registred successfully !';
        header("location:admin_login.php");
    }

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>register</title>

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
};

?>


<section class='form-container' >
    <form action="" method='post'>
        <h3>register now</h3>
        <input type="text" name='user' maxlength='20' placeholder='enter your username' class='box' required >
        <input type="password" name='pwd' maxlength='20' placeholder='enter your password' class='box' required >
        <input type="password" name='cpwd' maxlength='20' placeholder='confirme your password' class='box' required >
        <input type="submit" value="register now" name='submit' class='btn'>
    </form>
</section>


<!-- custom js file link -->
<script src="../js/admin_script.js" ></script>

</body>
</html>