<?php 
require 'connect.php';
$statement = $conn->prepare('SELECT * FROM feedback');
$statement->execute();
while ($row = $statement->fetch()) {
        $orders[] = $row;
}

// tìm kiếm
if( isset($_POST['search']) ) {
    // $products = (object)$products;
    switch ($_POST['search-type']) {
        case 'name-search':
            $statement = $conn->prepare('SELECT * FROM feedback where name like ? ');
            $statement->execute(['%'.$_POST['search'].'%']);
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);
            $orders = $row;
            break;

        case 'phone-search': 
            $statement = $conn->prepare('SELECT * FROM feedback where phone like ? ');
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
            $sapxep = "SELECT * FROM feedback ORDER BY name ASC";
        else
            $sapxep = "SELECT * FROM feedback ORDER BY name DESC";
    if($_POST['sort_name'] == 'day')
        if($_POST['sort_type'] == 'asc')
            $sapxep = "SELECT * FROM feedback ORDER BY created_at ASC";
        else
            $sapxep = "SELECT * FROM feedback ORDER BY created_at DESC";
    $stmt = $conn->prepare($sapxep);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $orders = $row;
}


// 
if(isset($_POST['done'])) {
    $note = 'Quên mật khẩu';
    $stmt = $conn->prepare('SELECT * FROM feedback WHERE id = ? AND note = ?');
    $stmt->execute([$_POST['done'],$note]);
    $exist = $stmt->fetch();
    if($exist != null) {
        $new_pass = 'abcdefghijklmnopqrstuvwxyz';
        $new_pass = substr(str_shuffle($new_pass),0,8);
        $stmt = $conn->prepare('UPDATE user SET password = ? WHERE phone_number = ?'); 
        $stmt->execute([$new_pass, $exist['phone']]);
        $stmt = $conn->prepare('UPDATE feedback SET note = ? WHERE id = ?');
        $stmt->execute(['Đã xử lý'.' Mật khẩu mới là: '.$new_pass, $_POST['done']]);
    }

    $stmt = $conn->prepare('UPDATE feedback SET status = ? WHERE id = ?');
    $stmt->execute(['Đã xử lý', $_POST['done']]);
    echo '<script>window.location="admin.php?nav=phanhoi"</script>';
}
if(isset($_POST['delete'])) {
    $stmt = $conn->prepare('DELETE FROM feedback WHERE id = ?');
    $stmt->execute([$_POST['delete']]);
    echo '<script>window.location="admin.php?nav=phanhoi"</script>';
}

?>


<form action="" method="post" class="offset-2 col-sm-10 py-2">
    <input type="text" name="search" class="h-100 col-sm-5 search" placeholder="Tìm kiếm theo">
    <select class="h-100 col-2" name="search-type">
        <option value="name-search">Tên</option>
        <option value="phone-search">Số điện thoại</option>
    </select>
    <button class="btn btn-danger">Tìm kiếm</button>
</form>
<form action="" method="post" class="offset-2 col-sm-10 py-2">
    <select class="h-100 col-auto" name="sort_name">
        <option value="name">Tên</option>
        <option value="day">Ngày phản hồi</option>
    </select>
    <select class="h-100 col-auto" name="sort_type">
        <option value="desc">Cao xuống thấp</option>
        <option value="asc">Thấp lên cao</option>
    </select>
    <button class="btn btn-danger" name="sort">Sắp xếp</button>
</form>

<h4 class="text-center">Phản hồi</h4>
<div class="col-sm-10 offset-2 products">
    <ul class="products__title row">
        <li class="col-sm-2 products__list__item ">Tên khách hàng</li>
        <!-- <li class="col-sm-2 products__list__item ">Họ Tên</li> -->
        <li class="col-sm-2 products__list__item ">Số điện thoại</li>
        <li class="col-sm-3 products__list__item ">Phản hồi</li>
        <li class="col-sm-2 products__list__item ">Ngày hản hồi</li>
        <li class="col-sm-1 products__list__item ">Trạng thái</li>

    </ul>
    <?php if(isset($orders)): ?>
    <?php foreach($orders as $order): ?> 

    <div class="products__list row">
        <div class="col-sm-2 products__list__item border border-start-0"><?php echo htmlspecialchars($order['name']) ?></div>
        <div class="col-sm-2 products__list__item border"><?php echo htmlspecialchars($order['phone']) ?></div>
        <div class="col-sm-3 products__list__item border"><?php echo htmlspecialchars($order['note']) ?></div>
        <div class="col-sm-2 products__list__item border"><?php echo htmlspecialchars($order['created_at']) ?></div>
        <div class="col-sm-1 products__list__item border"><?php echo htmlspecialchars($order['status']) ?></div>
        <div class="col-sm-2 products__list__item order__list__item--action">
            <form method="post">
                <button class="btn btn-danger" name="delete" value="<?= $order['id'] ?>"><i class="ri-delete-bin-line"></i></button>
                <button class="btn btn-success" name="done" value="<?= $order['id'] ?>"><i class="ri-check-line"></i></button>
            </form>  
        </div>

    </div>
    
    <?php endforeach; ?>
    <?php else: ?>
        <p class="offset-2">Chưa có đơn hàng nào.</p>
    <?php endif; ?>
</div>

