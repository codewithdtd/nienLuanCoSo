<?php
require_once 'class/user.php';
require_once 'class/product_class.php';
require_once 'class/gallery.php';

if(isset($_SESSION['id_user'])){
    $id_user = $_SESSION['id_user']; 
}
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

// thông báo khi đơn hàng sẵn sàng

$statement = $conn->prepare('SELECT * FROM ocake.orders WHERE user_id = ? AND status = "Sẵn sàng"');
try{
    $statement->execute([$id_user]);
    $all = $statement->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e){
    $all = "không có";
}




if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_product'])) {
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
                        <a class="cart-link cart-link--notify">
                            <i class="ri-notification-3-line"></i>
                            <div class="noty__count"><?= count($all) ?></div>
                            <div class="notify">
                                <?php if(isset($all)) foreach($all as $each): ?>
                                    <p class="my-2">Đơn hàng <b><?= $each['madonhang']; ?></b> đã sẵn sàng</p>
                                <?php endforeach; 
                                if(!isset($all)) echo '<p class="my-2">Không có thông báo</p>';
                                ?>
                                
                            </div>
                        </a>
                        <a href="cart.php" class="cart-link">
                            <i class="ri-shopping-basket-line"></i>
                            <div class="cart__count"><?= $count ?></div>
                        </a>
                    </div>
                    <?php if(!isset($id_user)):?>
                        <div class="login">
                            <i class="ri-user-line"></i>
                            <div class="user">
                                <a href="login.php">Đăng nhập</a>
                                <a href="register.php">Đăng ký</a>
                            </div>
                        </div>
                    <?php else: ?>   
                        <div class="login">
                            <i class="ri-user-line"></i>
                            <span class="name_user"><b><?= htmlspecialchars($user->getFulltName()) ?></b></span>
                            <div class="user">
                               
                                <h4><?= htmlspecialchars($user->getFulltName()) ?> </h4>
                                <a href="info_user.php?id=<?= $id_user ?>">Chỉnh sửa tài khoản</a>
                                <a href="info_user.php?id=<?= $id_user ?>&act=show">Xem thông tin đơn hàng</a>
                                <a href="login.php">Đăng xuất</a>
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
  
        $(".close_search").click(function () {
            $(".navbar__search__show").hide();
        });
       
       var currentPath = window.location.pathname + window.location.search;
       currentPath = currentPath.replace(/\//g, '');
    
        $(".navbar-list__item-link").each(function () {
            var linkPath = $(this).attr("href");
            console.log(linkPath);
            // Kiểm tra xem đường dẫn hiện tại có chứa đường dẫn của liên kết không
            if (currentPath.indexOf(linkPath) !== -1) {
                $(this).addClass("navbar-list__item-link--active");
                // $(this).closest('.aside__navbar_item').addClass("aside__navbar_item__link--active");
            }
        });
    })
</script>