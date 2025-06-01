<?php 

$dsn = 'mysql:host=localhost;dbname=eshop_db;' ;
$username = 'root' ;
$password = '' ;

$conn = new PDO($dsn,$username,$password);

// Define Action Logs Arrays

    $entity_type = array("product", "order", "user");
    $action_type = array("create", "update", "delete");
?>