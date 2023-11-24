<?php 
require_once 'user.php';
$user = new User($conn);

if(isset($_GET['id'])) {
    $user->deleteCart($_GET['id']);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['increase']))
        $user->updateCart($_POST['id']);
    if(isset($_POST['decrease']))
        $user->updateCartDecrease($_POST['id']);
    
    header('Location:cart.php');
}
