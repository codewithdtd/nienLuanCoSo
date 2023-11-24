<?php 
require_once 'user.php';
session_start();
unset($_SESSION['id_user']);    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['success']="Mật khẩu mới đã được gửi qua số điện thoại của bạn";
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
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">
    <title>Quên mật khẩu</title>
</head>
<body>
    <header class="header">
        <nav class="navbar__header navbar--login">
            <!-- logo -->
            <div class="navbar__logo">
                <a class="navbar__logo-link" href="index.php">
                    <img src="image/logo.png" alt="" class="logo-img">
                </a>
            </div>
            
            <!-- nav link -->
            <div class="navbar__items">
                <ul class="navbar__items-list">
                    <li class="navbar-list__item">
                        <a class="navbar-list__item-link" href="index.php">TRANG CHỦ</a>
                    </li>
                    <li class="navbar-list__item">
                        <a class="navbar-list__item-link" href="about.html">GIỚI THIỆU</a>
                    </li>
                    <li class="navbar-list__item">
                        <a class="navbar-list__item-link" href="product.php">SẢN PHẨM</a>
                    </li>
                    <li class="navbar-list__item">
                        <a class="navbar-list__item-link" href="contact.html">LIÊN HỆ</a>
                    </li>
                </ul>
            </div>
            <div class="navbar__menu">
                <i class="ri-menu-line"></i>
            </div>
        </nav>
    </header>
    <div class="login-page">
        <form method="post" class="login-form">
            <?php if(isset($_SESSION['success'])){
                        echo '<p style="padding:30px 0;background-color:#c0ffb8;margin-bottom:10px;font-size:0.8rem;color:green;">'.$_SESSION['success'].'</p>'; 
                        unset($_SESSION['success']);
            }
                    ?>
            <h1 class="login-form__title">Quên mật khẩu</h1>
            <div class="login-form__input">
                <label for="user__phone"><i class="ri-phone-fill"></i></label>
                <input required type="text" class="user__phone" name="phone" placeholder="Nhập số điện thoại">
            </div>
           
            <button class="login-form__submit">Gửi</button>
            <div class="register-link">
                <span>Quay về</span>
                <a href="login.php">Đăng nhập</a>
            </div>
        </form>
    </div>

    <!-- JS -->
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <!-- <script type="text/javascript" src="js/validate_form.js"></script> -->
</body>
</html>