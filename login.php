<?php 
require_once 'user.php';
session_start();
unset($_SESSION['id_user']);    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = new User($conn);
    $values = $role->check_user($phone, $password);
    if (isset($values)){
        if ($values == 1) {
            header('Location:admin.php');
            exit();
        }
        else {
            header('Location:index.php');
            exit();
        }
    }
    else 
        echo 'Thất bại';
}