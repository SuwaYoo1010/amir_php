<?php 
$password = '@Suwa1312';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo $password. '<br>';
echo $hashedPassword;
?>