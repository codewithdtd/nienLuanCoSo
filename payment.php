<?php 
session_start();
require_once 'class/user.php';

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $order = $user->addOrder();
    $user_id = $order['user_id'];
    $id = $order['id'];
  
    $statement = $conn->prepare('UPDATE ocake.cart
    SET order_id = ? WHERE user_id = ? ');
    $statement->execute([$id, $user_id]);
    

    $carts = $user->getAllCart($user_id);
    $user->deleteAllOrderDetail($id);
    header('Location:index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16"  href="image/favicons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="css/index.css" type="text/css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/payment.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">
    <title>Thanh toán</title>
</head>
<body>
    <?php require_once 'header.php';?>

    <main>
        <div class="container-fluid">
            <div class="row payment__body">
                <div class="col-sm-8 payment__body__cart">
                    <div class="row cart-page__title">
                        <p class="col-sm-6 cart-page__title__name"></p>
                        <p class="col-sm-2 cart-page__title__size">Kích thước</p>
                        <p class="col-sm-2 cart-page__title__quanlity">Số lượng</p>
                        <p class="col-sm-2 cart-page__title__price">Giá thành</p>
                    </div>
                    <?php
                        if(isset($id_user))
                            $carts = $user->getAllCart($id_user);
                        if(isset($carts))
                            foreach($carts as $cart): 
                    ?>
                    <div class="row cart-page__items">
                        <div class="col-sm-6 cart-page__items__names row">
                            <img src="<?= htmlspecialchars($cart['image'])?>" alt="" class="col-4 cart-page__items__names__img">
                            <span class="col-8 cart-page__items__names__name"><?= htmlspecialchars($cart['name'])  ?></span>
                        </div>
                        <div class="col-sm-2 border border-light border-top-0 border-bottom-0 cart-page__items__quanlity">
                            <p><?= htmlspecialchars($cart['size'])?></p>
                        </div>
                        <div class="col-sm-2 border border-light border-top-0 border-bottom-0 cart-page__items__quanlity">
                            <p><?= htmlspecialchars($cart['num']) ?></p>
                        </div>
                        <p class="col-sm-2 cart-page__items__price">
                            <?= htmlspecialchars(number_format($cart['total_money']))?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                    <!-- TOTAL -->
                    <div class="cart__page__total">
                        <p>Tổng số lượng: <span><?= $count ?></span></p>
                        <p>Thành tiền: <span><?= number_format($total_money) ?></span></p>
                    </div>
                </div>

            <!-- lấy thông tin khách hàng -->

                <div class="col-sm-4 payment__body__info">
                    <h4 class="payment__body__info__form__title">Thông tin thanh toán</h4>
                    <form method="post" class="payment__body__info__form" id="form">
                        <input required type="hidden" value="<?= $user->getId() ?>" name="id_user">
                        <label for="fullname">Họ tên:</label>
                        <input required type="text" name="fullname" value="<?= $user->getFulltName() ?>">
                        <label for="phone_number">Số điện thoại:</label>
                        <input required type="text" name="phone_number" value="<?= $user->getPhone_number() ?>">
                        <label for="address">Địa chỉ:</label>
                        <textarea name="address" class="payment__body__info__form__address"><?= $user->getAddress() ?></textarea>
                        <label for="payment">Phương thức thanh toán:</label>
                        <div class="text-center">COD<input type="radio" name="pt" value="cod" required>     Chuyển khoản<input type="radio" name="pt" value="Chuyển khoản" required></div>
                        <p style="font-size:0.8rem;">Chuyển khoản qua STK: 12312313 VIETCOMBANK</br>Nội dung: OCAKE-Số điện thoại-Họ tên</br> (VD: OCAKE-0123456789-DOTHANHDAT)</p>
                        <input required type="hidden" value="<?= $total_money ?>" name="total_money">
                                
                        <button class="payment__button">Xác nhận đặt hàng</button>
                        <p>Đơn hàng sẽ được giao sau 15 phút!</p>
                        <p>Cảm ơn quý khách vì đã chọn OCake nếu có bất kỳ thắc mắc nào vui lòng liên hệ hotline: 0123 456 789</p>
                    </form>
                </div>
            </div>
        </div>
    </main>

   <?php require_once 'footer.php' ?>
    
    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#form").submit(function(event) {
                alert("Đặt hàng thành công!");
            })
        })
    </script>
</body>
</html>