<?php 
require_once 'connect.php';
require_once 'user.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User($conn);
    $user->addUser();
    $user->fill($_POST);
    if(isset($_SESSION['error_message']))
        header('Location: register.php');
    else
        header("Location:login.html");
}
?>
