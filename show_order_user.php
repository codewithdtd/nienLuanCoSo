<?php 
require_once 'connect.php';


$statement = $conn->prepare('SELECT * FROM ocake.orders WHERE user_id = ?');
$statement->execute([$_GET['id']]);
$orders = $statement->fetchAll();
 
?>

<a href="#" class="offset-2" id="back">Quay lại</a>
<div class="order_detail offset-2 col-10">
<?php 
    if(isset($orders))
        foreach ($orders as $order):
?>
<div class="col-8 bg-white row border border-dark p-4 justify-content-center">
    <div class="col-sm-8">
        <h4>CHI TIẾT ĐƠN HÀNG</h4>
        <p>Mã đơn hàng: <?= $order['madonhang'] ?></p>
        <p>Khách hàng: <?= $order['fullname'] ?></p>
        <p>Số điện thoại: <?= $order['phone_number'] ?></p>
        <p>Địa chỉ: <?= $order['address'] ?></p>
        <p>Thời gian đặt hàng: <?= $order['order_date'] ?></p>
        <p>Tổng tiền: <?= number_format($order['total_money']) ?></p>
    </div>

    <?php 
            $orders_detail = [];
            $statement = $conn->prepare('SELECT * FROM ocake.order_details WHERE order_id = ?');
            $statement->execute([$order['id']]);
            while ($row = $statement->fetch()) {
                    $orders_detail[] = $row;
            }
    ?>


    <table class="col-sm-8">
        <tr>
            <th class="border border-dark">Hình ảnh</th>
            <th class="border border-dark">Tên bánh</th>
            <th class="border border-dark">Size</th>
            <th class="border border-dark">Số lượng</th>
            <th class="border border-dark">Giá</th>
        </tr>
        <?php foreach($orders_detail as $item): ?>
            <tr>
                <td class="border border-dark"><img src="<?= htmlspecialchars($item['image'])?>" style="width:50px;"></td>
                <td class="border border-dark"><?= htmlspecialchars($item['name'])?></td>
                <td class="border border-dark"><?= htmlspecialchars($item['size'])?></td>
                <td class="border border-dark"><?= htmlspecialchars($item['num'])?></td>
                <td class="border border-dark"><?= htmlspecialchars(number_format($item['total_money']))?></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<?php endforeach ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/back.js"></script>