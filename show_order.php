<?php 
require 'connect.php';
$statement = $conn->prepare('SELECT * FROM ocake.orders');
$statement->execute();
while ($row = $statement->fetch()) {
        $orders[] = $row;
}

// tìm kiếm
if( isset($_POST['search']) ) {
    // $products = (object)$products;
    switch ($_POST['search-type']) {
        case 'name-search':
            $statement = $conn->prepare('SELECT * FROM ocake.orders where madonhang like ? AND fullname <> "admin" ');
            $statement->execute(['%'.$_POST['search'].'%']);
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);
            $orders = $row;
            break;

        case 'phone-search': 
            $statement = $conn->prepare('SELECT * FROM ocake.orders where phone_number like ? AND fullname <> "admin" ');
            $statement->execute(['%'.$_POST['search'].'%']);
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);
            $orders = $row;
            break;
    }
}

// sắp xếp
if(isset($_POST['sort'])) {
    if($_POST['sort_name'] == 'name')
        if($_POST['sort_type'] == 'asc')
            $sapxep = "SELECT * FROM orders WHERE fullname <> 'admin' ORDER BY fullname ASC";
        else
            $sapxep = "SELECT * FROM orders WHERE fullname <> 'admin' ORDER BY fullname DESC";
    if($_POST['sort_name'] == 'day')
        if($_POST['sort_type'] == 'asc')
            $sapxep = "SELECT * FROM orders WHERE fullname <> 'admin' ORDER BY order_date ASC";
        else
            $sapxep = "SELECT * FROM orders WHERE fullname <> 'admin' ORDER BY order_date DESC";
    $stmt = $conn->prepare($sapxep);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $orders = $row;
}

?>


<form action="" method="post" class="offset-2 col-sm-10 py-2">
    <input type="text" name="search" class="h-100 col-sm-5 search" placeholder="Tìm kiếm theo">
    <select class="h-100 col-2" name="search-type">
        <option value="name-search">Mã đơn hàng</option>
        <option value="phone-search">Số điện thoại</option>
    </select>
    <button class="btn btn-danger">Tìm kiếm</button>
</form>
<form action="" method="post" class="offset-2 col-sm-10 py-2">
    <select class="h-100 col-auto" name="sort_name">
        <option value="name">Tên</option>
        <option value="day">Ngày đặt hàng</option>
    </select>
    <select class="h-100 col-auto" name="sort_type">
        <option value="desc">Cao xuống thấp</option>
        <option value="asc">Thấp lên cao</option>
    </select>
    <button class="btn btn-danger" name="sort">Sắp xếp</button>
</form>

<h4 class="offset-2 text-center">Đơn hàng</h4>
<div class="col-sm-10 offset-2">
    <div class="d-flex justify-content-between">
        <a class="products_add" href="admin.php?nav=themdonhang">+ Thêm mới</a>
    </div>
    <div class="products__title row">
        <div class="col-sm-3 products__list__item ">Mã đơn hàng</div>
        <!-- <div class="col-sm-2 products__list__item ">Họ Tên</div> -->
        <div class="col-sm-2 products__list__item ">Số điện thoại</div>
        <div class="col-sm-2 products__list__item ">Địa chỉ</div>
        <div class="col-sm-2 products__list__item ">Ngày đặt hàng</div>
        <div class="col-sm-1 products__list__item ">Tổng tiền</div>
        <div class="col-sm-1 products__list__item ">Trạng thái</div>

    </div>
    <?php if(isset($orders)): ?>
    <?php foreach($orders as $order): ?> 

    <div class="products__list row">
        <div class="col-sm-3 products__list__item border"><?php echo htmlspecialchars($order['madonhang']) ?></div>
        <!-- <div class="col-sm-2 products__list__item border"><?php echo htmlspecialchars($order['fullname']) ?></div> -->
        <div class="col-sm-2 products__list__item border"><?php echo htmlspecialchars($order['phone_number']) ?></div>
        <div class="col-sm-2 products__list__item border"><?php echo htmlspecialchars($order['address']) ?></div>
        <div class="col-sm-2 products__list__item border"><?php echo htmlspecialchars($order['order_date']) ?></div>
        <div class="col-sm-1 products__list__item border"><?php echo htmlspecialchars(number_format($order['total_money'])) ?></div>
        <div class="col-sm-1 products__list__item border"><?php echo htmlspecialchars($order['status']) ?></div>
        <div class="col-sm-1 products__list__item order__list__item--action">
            <button class="edit">
                <a href="admin.php?nav=suadonhang&id=<?=$order['id'] ?>">Sửa</a>
            </button>  
            <button class="delete">
                <a href="delete.php?id_order=<?= $order['id']?>">Xóa</a>
            </button></br>
            <a href="admin.php?nav=chitietdonhang&id=<?=$order['id'] ?>">Xem chi tiết</a>
        </div>

    </div>

    <?php endforeach; ?>
    <?php else: ?>
        <p class="offset-2">Chưa có đơn hàng nào.</p>
    <?php endif; ?>
</div>

