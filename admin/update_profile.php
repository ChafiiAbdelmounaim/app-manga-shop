<?php  

include '../components/connect.php' ;

session_start();
$admin_id = $_SESSION['admin_id'] ;

if (!isset($admin_id)) {
    header('location:admin_login.php');
};

if (isset($_POST['submit'])) {

    $name = filter_var($_POST['user'],FILTER_SANITIZE_STRING);

    if ($name == '') {
        
    }else{
        $update_name  = $conn->prepare("UPDATE admins SET name= :name WHERE id=:aid");
        $update_name->bindParam(":aid",$admin_id);
        $update_name->bindParam(":name",$name);
        $update_name->execute();
        $message[] = 'username updated successfully !';
    }


    $empty_pass = 'd41d8cd98f00b204e9800998ecf8427e';

    // fetch old pass
    $select_old_pass = $conn->prepare("SELECT password FROM admins WHERE id = :aid ");
    $select_old_pass->bindParam(":aid",$admin_id);
    $select_old_pass->execute();

    $fetch_old_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_old_pass['password'];

    $old_pass = md5(filter_var($_POST['old_pwd'],FILTER_SANITIZE_STRING)) ;
    $new_pass = md5(filter_var($_POST['new_pwd'],FILTER_SANITIZE_STRING)) ;
    $cnew_pass = md5(filter_var($_POST['c_new_pwd'],FILTER_SANITIZE_STRING)) ;

    if( $old_pass == $empty_pass ) {
        $message[] = 'please enter old password !';
    }elseif ($old_pass != $prev_pass) {
        $message[] = 'old password not matched !';
    }elseif ($new_pass != $cnew_pass) {
        $message[] = 'confirm password not matched !';
    }else {
        if ( $new_pass != $empty_pass ) {
            $update_pass = $conn->prepare("UPDATE admins SET password= :password WHERE id=:aid");
            $update_pass->bindParam(":aid",$admin_id);
            $update_pass->bindParam(":password",$new_pass);
            $update_pass->execute();
            $message[] = 'password updated successfully !';
        }else {
            $message[] = 'please enter the new password !';
        }
    }

};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>profile update</title>

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

<section class='form-container' >
    <form action="" method='post'>
        <h3>update profile</h3>
        <input type="text" name='user' maxlength='20' placeholder='enter your username' class='box'>
        <input type="password" name='old_pwd' maxlength='20' placeholder='enter your old password' class='box'>
        <input type="password" name='new_pwd' maxlength='20' placeholder='enter your password' class='box'>
        <input type="password" name='c_new_pwd' maxlength='20' placeholder='confirme your password' class='box'>
        <input type="submit" value="update now" name='submit' class='btn'>
    </form>
</section>


<!-- custom js file link -->
<script src="../js/admin_script.js" ></script>

</body>
</html>