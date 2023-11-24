<?php
require_once 'class/user.php';
$user = new User($conn);


// xử lý Post
if(isset($_POST['id_product'])){
    $id_product = $_POST['id_product'];
    $id_user = $_POST['id_user'];
    $img = $_POST['img'];
    $name = $_POST['name'];
    $num = 1;
    if(isset($_POST['num'])) {
        $num = $_POST['num'];
    }
    // lấy size
    if(isset($_POST['priceS'])){
        $price = $_POST['priceS'];
        $size = 'S';
    }
    elseif(isset($_POST['priceM'])){
        $price = $_POST['priceM'];
        $size = 'M';
    }
    elseif(isset($_POST['priceL'])){
        $price = $_POST['priceL'];
        $size = 'L';
    }
    
    $order = [  'id_user' => $id_user,
                'id_product' => $id_product,
                'name' => $name, 
                'img' => $img, 
                'size' => $size, 
                'num' => $num, 
                'price' => $price];
     
    $user->addcart($order);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
