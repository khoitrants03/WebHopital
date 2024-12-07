
<?php
$db_name = 'mysql:host=127.0.0.1:3307;dbname=ql_bv;charset=utf8mb4';

// $db_name = 'localhost;dbname=ql_bv;charset=utf8mb4'; code này mở ra để update
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);
?>
