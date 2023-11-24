<?php 
require_once 'user.php';
session_start();
unset($_SESSION['id_user']);

unset($_SESSION['id_user']);    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = new User($conn);
    $values = $role->check_user($phone, $password);
    if(isset($_POST['login-checkbox'])) {
        $_SESSION['phone'] = $_POST['phone'];
        $_SESSION['password'] = $_POST['password'];
    }
    else if(!isset($_POST['login-checkbox'])) {
        unset($_SESSION['phone']);
        unset($_SESSION['password']);
    }
    if (isset($values)){
        if ($values == 1) {
            header('Location:admin.php');
            exit();
        }
        else {
            header('Location:index.php');
            exit();
        }
    }
    else 
        $_SESSION['error']="Số điện thoại hoặc mật khẩu không đúng";
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
    <title>Đăng nhập</title>
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
            <?php if(isset($_SESSION['error'])){
                        echo '<p class="error" style="padding:30px 0;background-color:#ffb8b8;margin-bottom:10px;font-size:1rem;">'.$_SESSION['error'].'</p>'; 
                        unset($_SESSION['error']);
            }
                    ?>
            <h1 class="login-form__title">Đăng nhập</h1>
            <div class="login-form__input">
                <label for="user__phone"><i class="ri-user-fill"></i></label>
                <input type="text" class="user__phone" name="phone" placeholder="Nhập số điện thoại" value="<?php if(isset($_SESSION['phone'])) echo $_SESSION['phone']; ?>">
            </div>
            <div class="login-form__input">
                <label for="user__password"><i class="ri-lock-fill"></i></label>
                <input type="password" class="user__password" name="password" placeholder="Nhập mật khẩu" value="<?php if(isset($_SESSION['password'])) echo $_SESSION['password']; ?>">
            </div>
            
            <div class="login-form__remember">
                <div class="remember">
                    <input type="checkbox" name="login-checkbox">
                    <label for="login-checkbox">Ghi nhớ đăng nhập</label>
                </div>
                <a href="forgot_pass.php" class="forgot-password">Quên mật khẩu?</a>
            </div>
            <button class="login-form__submit">Đăng nhập</button>
            <div class="register-link">
                <span>Bạn chưa có tài khoản?</span>
                <a href="register.php">Đăng ký ngay</a>
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