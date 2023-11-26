<?php 
require 'connect.php';


// phẩn của update
$statement = $conn->prepare('SELECT * FROM ocake.orders WHERE id = ?');
$statement->execute([$_GET['id']]);
$order = $statement->fetch();
 


$statement = $conn->prepare('SELECT * FROM ocake.order_details WHERE order_id = ?');
$statement->execute([$_GET['id']]);
while ($row = $statement->fetch()) {
    $orders_detail[] = $row;
}

$total = 0;
if(isset($_GET['act']) && $_GET['act']==='del') {
    try {
        $delete = $conn->prepare('DELETE FROM ocake.order_details WHERE id = ?');
        $delete->execute([(int)$_GET['id_od']]);
    }
    catch(Exception $e) {
        echo $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    $statement = $conn->prepare('UPDATE ocake.orders SET fullname = ?, phone_number = ?, address = ?, total_money = ?, status = ? WHERE id = ?');
    $statement->execute([   $_POST['fullname'],
                            $_POST['phone'],
                            $_POST['address'],
                            $_POST['total'],
                            $_POST['status'],
                            $_GET['id']
                        ]);
    
    echo '<p class="offset-2 alert alert-success">Cập nhật thành công!</p>';
}


?>
    
<span class="offset-2">
    <a href="admin.php?nav=donhang" id="back" class="btn btn-primary">Quay lại</a>
</span>
<form method="post" class="offset-2 sregister-form">
    <h1 class="register-form__title">Chỉnh sửa thông tin đơn hàng</h1>
    
    <div class="register-form__input">
        <label for="fullname" class="col-sm-2">Họ tên:</label>
        <input required type="text" class="user__name col-sm-6" name="fullname" value="<?= htmlspecialchars($order['fullname']) ?>">
    </div>
    <div class="register-form__input">
        <label for="phone" class="col-sm-2">Số điện thoại:</label>
        <input required type="text" class="user__phone col-sm-6" name="phone" value="<?= htmlspecialchars($order['phone_number']) ?>">
    </div>           

    <div class="register-form__input">
        <label for="address" class="col-sm-2">Địa chỉ:</label>
        <input required type="text" class="user__address col-sm-6" name="address" value="<?= htmlspecialchars($order['address']) ?>">
    </div>

    <div class="register-form__input">
        <label for="address" class="col-sm-2">Trạng thái:</label>
        <select name="status" class="h-100">
            <option value="<?= htmlspecialchars($order['status']) ?>"><?= htmlspecialchars($order['status']) ?></option>
            <option value="Chưa giao">Chưa giao</option>
            <option value="Sẵn sàng">Sẵn sàng</option>
            <option value="Đã giao">Đã giao</option>
            <option value="Đã hủy">Đã hủy</option>
        </select>
        <!-- <input required type="text" class="user__address col-sm-6" name="status" value=""> -->
    </div>

    <table class="col-sm-8 bg-light m-4">
        <tr>
            <th class="border border-dark">Hình ảnh</th>
            <th class="border border-dark">Tên bánh</th>
            <th class="border border-dark">Size</th>
            <th class="border border-dark">Số lượng</th>
            <th class="border border-dark">Giá</th>
            <!-- <th></th> -->
        </tr>
        <?php foreach($orders_detail as $item): ?>
            <tr>
                <td class="border border-dark"><img src="<?= htmlspecialchars($item['image'])?>" style="width:50px;"></td>
                <td class="border border-dark"><?= htmlspecialchars($item['name'])?></td>
                <td class="border border-dark"><?= htmlspecialchars($item['size'])?></td>
                <td class="border border-dark"><?= htmlspecialchars($item['num'])?></td>
                <td class="border border-dark"><?= htmlspecialchars(number_format($item['total_money']))?></td>
                <?php $total+=$item['total_money'] ?>
                
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="register-form__input">
        <label for="tôtl" class="col-sm-2">Tổng tiền:</label>
        <input required type="number" class="user__address col-sm-6 disable" name="total" value="<?= htmlspecialchars($total) ?>" readonly>
    </div>
    <button class="register-form__submit btn btn-success" type="submit">Cập nhật</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/back.js"></script>

</body>
</html>