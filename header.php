<?php
require_once 'user.php';
require_once 'product_class.php';
require_once 'gallery.php';

if(isset($_SESSION['id_user'])){
    $id_user = $_SESSION['id_user']; 
}
$count = 0;
$total_money = 0;
if(isset($id_user)){
    $user = new User($conn);
    $user->find($id_user);
    
    $item = $user->getAllOrderDetail($id_user);
    if(isset($item)){
        foreach ($item as $number) {
            $GLOBALS['count'] += $number['num'];
            $GLOBALS['total_money'] += $number['total_money'];
        }
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['search_product'] !== '') {
    $name = '%'.$_POST['search_product'].'%';

    $statement = $conn->prepare('SELECT * FROM ocake.product WHERE name LIKE ?');
    if($statement->execute([$name])) {
        $gallery = new Gallery($conn);
        $imgs = $gallery->getAllGallery();
    }
    while ($item = $statement->fetch()){
        $search[] = $item;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/index.css" type="text/css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">
    <title>Trang chủ</title>
</head>

<header class="header">
        <nav class="navbar__header">
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

            <!-- Nav search -->
            <div class="navbar__search-login">
                <form method="post" class="navbar__search">
                    <input type="text" class="navbar__search__input" name="search_product">
                    <button for="search_product" class="navbar__search__label">
                        <i class="ri-search-line"></i>
                    </button>
                    <?php if(isset($name)): ?>
                    <div class="navbar__search__show">
                        <div class="navbar__search__show-info">
                            <?php 
                                foreach($search as $item){
                                    foreach($imgs as $img)
                                        if($img->product_id == $item['id']) {
                                            echo '<a href="product_detail.php?id='.$item['id'].'" class="img_name">
                                                    <img src="'.$img->thumbnail.'" class="img_search">
                                                    <span>'.$item['name'].'</span>
                                                </a></br>';
                                            break;
                                        }
                                }
                            ?>
                            <p class="close_search">Đóng</p>
                        </div>
                    <?php endif; ?>
                    </div>
                </form>
                <div class="navbar__login-cart">
                    <div class="cart">
                        <a href="cart.php" class="cart-link">
                            <i class="ri-shopping-basket-line"></i>
                            <div class="cart__count"><?= $count ?></div>
                        </a>
                    </div>
                    <?php if(!isset($id_user)):?>
                        <div class="login">
                            <i class="ri-user-line"></i>
                            <div class="user">
                                <a href="login.html">Đăng nhập</a>
                                <a href="register.php">Đăng ký</a>
                            </div>
                        </div>
                    <?php else: ?>   
                        <div class="login">
                            <i class="ri-user-line"></i>
                            <div class="user">
                               
                                <h4><?= htmlspecialchars($user->getFulltName()) ?> </h4>
                                <a href="edit_user.php?id=<?= $id_user ?>">Chỉnh sửa tài khoản</a>
                                <a href="#">Xem thông tin đơn hàng</a>
                                <a href="logout.php">Đăng xuất</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>   
                <div class="navbar__menu">
                    <i class="ri-menu-line"></i>
                </div>                  
            </div>
        </nav>
    </header>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Bắt sự kiện click vào phần tử có class "close_search"
        $(".close_search").click(function () {
            // Sử dụng phương thức hide() để ẩn phần tử có class "navbar__search__show"
            $(".navbar__search__show").hide();
        });
        // $(".navbar__search").submit(function () {
        //     event.preventDefault();
        //     $(".navbar__search__show").show();
        // })
});
</script>