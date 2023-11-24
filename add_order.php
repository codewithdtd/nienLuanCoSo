<?php 
require 'connect.php';
require_once 'class/user.php';

require_once 'class/product_class.php';
require_once 'class/gallery.php';
$product = new Product($conn);
$gallerys = new Gallery($conn);

$list = $product->getAllProducts();
$list_gallery = $gallerys->getAllGallery();


$count = 0;
$total_money = 0;
if(isset($id_user)){
    $user = new User($conn);
    $user->find($id_user);
    
    $item = $user->getAllCart($id_user);
    if(isset($item)){
        foreach ($item as $number) {
            $GLOBALS['count'] += $number['num'];
            $GLOBALS['total_money'] += $number['total_money'];
        }
    }
}



$statement = $conn->prepare('SELECT * FROM ocake.cart WHERE user_id = ?');
$statement->execute(['12']);
while ($row = $statement->fetch()) {
    $orders_detail[] = $row;
}

$total = 0;
if(isset($_GET['act']) && $_GET['act']==='del') {
    try {
        $delete = $conn->prepare('DELETE FROM ocake.cart WHERE id = ?');
        $delete->execute([(int)$_GET['id_od']]);
    }
    catch(Exception $e) {
        echo $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_newOrder'])) { 
    $order = $user->addOrder();
    $user_id = $order['user_id'];
    $id = $order['id'];
    $statement = $conn->prepare('UPDATE ocake.cart
    SET order_id = ? WHERE user_id = ? ');
    $statement->execute([$id, $user_id]);
    

    $carts = $user->getAllCart($user_id);
    $user->deleteAllOrderDetail($id);
    echo '<script>alert("Thành công");window.location="admin.php?nav=themdonhang";</script>';
}


?>
    
<span class="offset-2">
    <a href="admin.php?nav=donhang" id="back" class="btn btn-primary">Quay lại</a>
</span>
<div class="offset-2 row">
    <?php if(isset($_SESSION['add_order'])): ?>
        <p class="alert alert-success"><?= $_SESSION['add_order'] ?></p>
    <?php unset($_SESSION['add_order']); endif; ?>
    <h1 class="text-center">Thêm đơn hàng mới</h1>
    <div class="col-sm-5 text-center">
        <table class="bg-light text-center">
            <tr>
                <th class="border border-dark col-sm-2">Hình ảnh</th>
                <th class="border border-dark col-sm-2">Tên bánh</th>
                <th class="border border-dark col-sm-2">Size</th>
                <th class="border border-dark col-sm-2">Số lượng</th>
                <th class="border border-dark col-sm-2">Giá</th>
                <th class="border border-dark col-sm-2"></th>
            </tr>
            <?php if(isset($orders_detail)) foreach($orders_detail as $item): ?>
                <tr>
                    <td class="border border-dark"><img src="<?= htmlspecialchars($item['image'])?>" style="width:50px;"></td>
                    <td class="border border-dark"><?= htmlspecialchars($item['name'])?></td>
                    <td class="border border-dark"><?= htmlspecialchars($item['size'])?></td>
                    <td class="border border-dark"><?= htmlspecialchars($item['num'])?></td>
                    <td class="border border-dark"><?= htmlspecialchars(number_format($item['total_money']))?></td>
                    <td class="border border-dark">
                        <a href="deleteOrder.php?id=<?= htmlspecialchars($item['id']) ?>" class="btn btn-danger">
                            <i class="ri-delete-bin-line"></i>
                        </a>     
                    </td>
                    <?php $total+=$item['total_money'] ?>
                </tr>   
            <?php endforeach; ?>
        </table>
        <button class="btn btn-success" name="add_cart">+ Thêm sản phẩm</button>
    </div>
    <form method="post" class="col-sm-7 add_order">
        <input type="hidden" name="id_user" value="<?= $id_user ?>">
        <div class="">
            <label for="fullname" class="col-sm-4">Họ tên:</label>
            <input type="text" class="user__name col-sm-8" name="fullname" value="" required>
        </div>
        <div class="">
            <label for="phone" class="col-sm-4">Số điện thoại:</label>
            <input type="text" class="user__phone col-sm-8" name="phone_number" value="" required>
        </div>           
        <div class="">
            <label for="address" class="col-sm-4">Địa chỉ:</label>
            <input type="text" class="user__address col-sm-8" name="address" value="" required>
        </div>
        <div class="">
            <label for="address" class="col-sm-8">Phương thức thanh toán:</label>  
            <div class="text-center col-sm-8">COD<input type="radio" name="pt" value="cod" required>     Chuyển khoản<input type="radio" name="pt" value="Chuyển khoản" required></div>
        
        </div>
        <div class="">
            <label for="total" class="col-sm-4">Tổng tiền:</label>
            <input type="number" class="user__address col-sm-8 disable" name="total_money" value="<?= htmlspecialchars($total) ?>" required readonly>
        </div>
        <button class="btn btn-success" type="submit" name="add_newOrder">Thêm mới</button>
    </form>
</div>
<div id="cart" class="modal fade row" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đặt hàng</h4>
                <button type="button" class="close btn btn-outline-danger" data-bs-dismiss="modal">
                    <span>X</span>
                </button>
            </div>
            <div class="modal-body">
                <?php foreach ($list as $sp): ?>
                <form action="add_cart.php" method="post" class="add row">
                    <input type="hidden" name="id_user" value="12">
                    <input type="hidden" name="id_product" value="<?= $sp->getID() ?>">

                    <?php 
                        $firstImg = null;
                        foreach($list_gallery as $imgs) 
                            if ($imgs->product_id == $sp->getID() && $firstImg === null) 
                                $firstImg = $imgs->thumbnail;
                        echo '<img src="'.$firstImg.'" alt=""  class="w-25"></a>
                            <input type="hidden" name="img" value="'.$firstImg.'">';
                        ?>
                    <img src="" class="w-25">
                    <div>
                        <label for="name" class="col-sm-2">Tên:</label>
                        <input type="text" name="name" value="<?= $sp->name ?>">
                    </div>
                    <div>
                        <label for="price" class="col-sm-2">Size:</label>
                        S<input type="checkbox" name="priceS" class="size" value="<?= $sp->priceS ?>">
                        M<input type="checkbox" name="priceM" class="size"  value="<?= $sp->priceM ?>">
                        L<input type="checkbox" name="priceL" class="size"  value="<?= $sp->priceL ?>">

                    </div>
                    <div>
                        <label for="quanlity" class="col-sm-2">Số lượng:</label>
                        <input type="number" name="num" value="1" required>
                    </div>
      
                    <button type="submit" class="btn btn-dark border-white" name="add_cart">Thêm</button>
                </form>
                <?php endforeach ?>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button> -->
            </div>
        </div>
    </div>
</div>
<script src="js/back.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // Xử lý sự kiện khi nút "Thêm giỏ hàng" được click
        $('button[name="add_cart"]').on('click', function() {
            // Hiển thị form
            // e.preventDefault();
            $('#cart').modal('show');
        })

            $(".add").submit(function(event) {
                <?php if(isset($user)) 
                        $check = 1;
                        else $check = 0; 
                ?>
                if(!<?= $check ?>){
                    alert("Vui lòng đăng nhập để mua sản phẩm!");
                    event.preventDefault();
                }

                else if(!$(".size").is(":checked")) {
                        alert("Vui lòng chọn size.");
                        event.preventDefault();
                    }
                else if($(".size:checked").length > 1) {
                    alert("Chỉ chọn 1 size.");
                    event.preventDefault();
                }
                else if($(".size").is(":checked")) {
                        alert("Thêm sản phẩm thành công!");
                    }
            });
         });
    
</script>
</body>
</html>