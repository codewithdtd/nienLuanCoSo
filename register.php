<?php 
require_once 'connect.php';
require_once 'class/user.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User($conn);
    $user->addUser();
    $user->fill($_POST);
    if(isset($_SESSION['error_message'])){
        echo "<div class='error_register'>".$_SESSION["error_message"]."</div>";
        unset($_SESSION["error_message"]);
    }
    else {
        header("Location:login.php");
        exit();
    }
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
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">
    <title>Đăng ký</title>
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
                        <a class="navbar-list__item-link" href="about.php">GIỚI THIỆU</a>
                    </li>
                    <li class="navbar-list__item">
                        <a class="navbar-list__item-link" href="product.php">SẢN PHẨM</a>
                    </li>
                    <li class="navbar-list__item">
                        <a class="navbar-list__item-link" href="contact.php">LIÊN HỆ</a>
                    </li>
                </ul>
            </div>
            <div class="navbar__menu">
                <i class="ri-menu-line"></i>
            </div>
        </nav>
    </header>
    <div class="register-page">
        <form method="post" action="" class="register-form">
            <?php 
            // session_start();
                if(isset($_SESSION["error_message"])){
                    echo "<div class='error_register'>".$_SESSION["error_message"]."</div>";
                    unset($_SESSION["error_message"]);
                }
            ?>
            <h1 class="register-form__title">Đăng ký</h1>
            
            <div class="register-form__input">
                <label for="fullname">Họ tên:</label>
                <input type="text" class="user__name" name="fullname" placeholder="Nhập tên của bạn">
            </div>
            <div class="register-form__input">
                <label for="birthday">Ngày sinh:</label>
                <input type="date" class="user__birthday" name="birthday">
            </div>
        
            <div class="register-form__input">
                <label for="email">Email: (Nếu có)</label>
                <input type="text" class="user__email" name="email" placeholder="Nhập email">
            </div>
            <div class="register-form__input">
                <label for="phone">Số điện thoại:</label>
                <input type="text" class="user__phone" name="phone" placeholder="Nhập số điện thoại">
            </div>           
        
        
            <div class="register-form__input">
                <label for="password">Mật khẩu:</i></label>
                <input type="password" class="user__password" name="password" placeholder="Nhập mật khẩu ">
            </div>
            <div class="register-form__input">
                <label for="password_confirm">Nhập lại mật khẩu:</label>
                <input type="password" class="user__password_confirm" name="password_confirm" placeholder="Nhập lại mật khẩu ">
            </div>

            <div class="register-form__input">
                <label for="address">Địa chỉ:</label>
                <input type="text" class="user__address" name="address" placeholder="Nhập địa chỉ">
            </div>

            <button class="register-form__submit" type="submit">Đăng ký</button>
            <div class="login-link">
                <span>Bạn đã có tài khoản</span>
                <a href="login.php">Đăng nhập</a>
            </div>
        </form>
    </div>

    <!-- JS -->
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/validate_form.js"></script>
</body>
</html>