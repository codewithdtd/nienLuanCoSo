<?php
session_start();
require_once 'class/user.php';

$user = new User($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16"  href="image/favicons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">

    <title>Giỏ hàng</title>
</head>
<body>
    <?php require_once 'header.php' ?>
    <main>
        <div class="container-fluid cart-page">
            <h3>Giỏ hàng của bạn</h3>
            <div class="row cart-page__title">
                <p class="col-sm-5 cart-page__title__name"></p>
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
                <div class="col-sm-5 cart-page__items__names row">
                    <img src="<?= htmlspecialchars($cart['image'])?>" alt="" class="col-4 cart-page__items__names__img">
                    <span class="col-8 cart-page__items__names__name"><?= htmlspecialchars($cart['name'])  ?></span>
                </div>
                <div class="col-sm-2 border border-2 border-white border-top-0 border-bottom-0 cart-page__items__quanlity">
                    <p><?= htmlspecialchars($cart['size'])?></p>
                </div>
                <div class="col-sm-2 border border-2 border-white border-top-0 border-bottom-0 cart-page__items__quanlity">
                    <form action="deleteOrder.php" method="post" >
                        <input type="hidden" name="id" value="<?= $cart['id'] ?>">
                        <button type="submit" value="1" name="decrease">-</button>
                        <p><?= htmlspecialchars($cart['num']) ?></p>
                        <button value="<?= $cart['product_id'] ?>" name="increase">+</button>
                    </form>
                </div>
                <p class="col-sm-2 cart-page__items__price">
                    <?= htmlspecialchars(number_format($cart['total_money']))?>
                </p>
                <a class="col-sm-1 cart-page__items__delete" href="deleteOrder.php?id=<?= $cart['id'] ?>">
                    <i class="ri-delete-bin-line"></i>
                </a>
            </div>
            <?php endforeach; ?>
            <!-- TOTAL -->
            <div class="cart__page__total">
                <p>Tổng số lượng: <span><?= $count ?></span></p>
                <p>Thành tiền: <span><?= number_format($total_money) ?></span></p>
                <a href="payment.php" class="cart__page__total__button">Thanh toán</a>
            </div>
        </div>
    </main>

    <?php require_once 'footer.php' ?>
    
    <script src="js/main.js"></script>
</body>
</html>