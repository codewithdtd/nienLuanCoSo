<?php 
require_once 'connect.php';
require_once 'class/product_class.php';
require_once 'class/user.php';

$sanpham = new Product($conn);
$sanpham = $sanpham->getAllProducts();

$user = new User($conn);
$user = $user->getAllUser();


$user_count = 0;
$sanpham_count = 0;
$donhang_count = 0;
$donhangmoi_count = 0;
$doanhthu = 0;
$user_count = count($user);
$sanpham_count = count($sanpham);


$statement = $conn->prepare('SELECT total_money FROM orders');
$statement->execute();
$donhang = $statement->fetchAll();
$donhang_count = count($donhang);

foreach($donhang as $item){
    $doanhthu+=$item['0'];
}


$statement = $conn->prepare('SELECT * FROM orders WHERE status = "Chưa giao"');
$statement->execute();

$donhangmoi_count = count($statement->fetchAll());



?>
<div class="offset-1 home">
    <div class="row title col-sm-9 m-4">
        <h3>Chào Mừng Đến Với Trang Quản Lý</h3>
    </div>
    <div class="row">
        <div class="col-sm-2 statistic">
            <h4>Khách hàng</h4>
            <p><?= $user_count ?> <i class="ri-map-pin-user-fill"></i></p>
        </div>
        <div class="col-sm-5 statistic">
            <h4>Đơn hàng</h4>
            <p><?= $donhang_count ?> <i class="ri-bill-fill"></i>
                <span><?= $donhangmoi_count ?> đơn hàng mới</span>
            </p>
            
        </div>
        <div class="col-sm-2 statistic">
            <h4>Sản phẩm</h4>
            <p><?= $sanpham_count ?> <i class="ri-cake-3-fill"></i></p>
        </div>
    </div>
    <div class="row doanhthu col-sm-9">
      <h4 class="py-3">Tổng Doanh Thu</h4>
      <p><?= number_format($doanhthu) ?> <i class="ri-money-dollar-circle-fill"></i></p>
    </div>
</div>
