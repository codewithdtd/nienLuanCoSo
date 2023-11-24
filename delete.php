<?php
require_once 'class/gallery.php';
require_once 'class/product_class.php';
require_once 'class/user.php';
session_start();
$product = new Product($conn);
$gallery = new Gallery($conn);
$user = new User($conn);

if(isset($_POST['id_img']))
    $values = $gallery->find($_POST['id_img']);

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id_img']) && isset($values)
) {
    $values->delete($values->thumbnail);
    header('Location:admin.php?nav=suasanpham&id='.$values->product_id);
    exit();

}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_product'])) {
    $product->find($_POST['id_product']);
    $imgs = $gallery->findGallery($_POST['id_product']);
    $gallery->deleteProduct($imgs);
    $product->delete();
    $_SESSION["success"] = "Đã xóa sản phẩm";
    header('Location:admin.php?nav=sanpham');
    exit();

} 

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_user'])) {
    $user->find($_POST['id_user']); 
    $user->delete();
    header('Location:admin.php?nav=khachhang');
    exit();

}

// xóa đơn hàng
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_order'])) {
    $statement = $conn->prepare('DELETE FROM ocake.order_details WHERE order_id = ?');
    $statement->execute([$_GET['id_order']]);
    $statement = $conn->prepare('DELETE FROM ocake.orders WHERE id = ?');
    $statement->execute([$_GET['id_order']]);
    header('Location:admin.php?nav=donhang');
    exit();

}

// xóa danh mục 
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_category'])) {
    $statement = $conn->prepare('DELETE FROM ocake.category WHERE id = ?');
    $statement->execute([$_POST['id_category']]);
    header('Location:admin.php?nav=category');
    exit();
}