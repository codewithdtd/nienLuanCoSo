<?php 
session_start();
// user
if(isset($_SESSION['id_user']) && $_SESSION['id_user']=='12' ){
    $id_user = $_SESSION['id_user']; 
}
else 
    echo '<script>alert("Vui lòng đăng nhập");window.location="login.php";</script>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16"  href="image/favicons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/show_product.css">
    <link rel="stylesheet" href="css/statistic.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Quản lý</title>
</head>
<body>
    <div class="container-fluid">
        <div class="aside-left">
            <img src="image/logo.png" alt="" class="logo-img">
            <ul class="aside__navbar">
                <li class="aside__navbar_item">
                    <a href="admin.php?nav=home" class="aside__navbar_item__link">
                        <i class="ri-home-2-line"></i>
                        <span>Trang chủ</span>
                    </a>    
                </li>
                <li class="aside__navbar_item">
                    <a href="admin.php?nav=category" class="aside__navbar_item__link">
                        <i class="ri-list-check"></i>
                        <span>Danh mục</span>
                    </a>    
                </li>
                <li class="aside__navbar_item">
                    <a href="admin.php?nav=sanpham" class="aside__navbar_item__link">
                        <i class="ri-cake-2-line"></i>
                        <span>Sản phẩm</span>
                    </a>
                </li>
                <li class="aside__navbar_item">
                    <a href="admin.php?nav=donhang" class="aside__navbar_item__link">
                        <i class="ri-bill-line"></i>
                        <span>Đơn hàng</span>
                    </a>
                </li>
                <li class="aside__navbar_item">
                    <a href="admin.php?nav=khachhang" class="aside__navbar_item__link">
                        <i class="ri-file-user-line"></i>
                        <span>Khách hàng</span>
                    </a>
                </li>
                <li class="aside__navbar_item">
                    <a href="admin.php?nav=phanhoi" class="aside__navbar_item__link">
                        <i class="ri-message-3-line"></i>
                        <span>Phản hồi</span>
                    </a>
                </li>
                <li class="aside__navbar_item">
                    <a href="login.php" class="aside__navbar_item__link">
                        <i class="ri-login-box-line"></i>
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>
        <main class="row">
            <?php 
                if(isset($_GET["nav"]))
                    switch($_GET['nav']) {
                        case 'category' :
                            require_once "category.php";
                            break;
                        case 'sanpham' :
                            require_once "show_product.php";
                            break;
                        case 'themsanpham' :
                            require_once "add_product.php";
                            break;
                        case 'suasanpham' :
                            require_once "edit_product.php";
                            break;
                        case 'khachhang' :
                            require_once "show_user.php";
                            break;
                        case 'themkhachhang' :
                            require_once "add_user.php";
                            break;
                        case 'suakhachhang' :
                            require_once "edit_user.php";
                            break;
                        case 'chitietdonhang' :
                            require_once "order_detail.php";
                            break;
                        case 'donhang' :
                            require_once "show_order.php";
                            break;
                        case 'themdonhang' :
                            require_once "add_order.php";
                            break;
                        case 'suadonhang' :
                            require_once "edit_order.php";
                            break;
                        case 'home' :
                            require_once "statistic.php";
                            break;
                        default:
                            require_once "statistic.php";
                            break;
            } 
            else 
                require_once "statistic.php";
                
            ?>
        </main>
    </div>
 <script>
    $(document).ready(function(){
        var currentPath = window.location.pathname + window.location.search;
        currentPath = currentPath.replace(/\//g, '');
  
        $(".aside__navbar_item__link").each(function () {
            var linkPath = $(this).attr("href");
            console.log(linkPath);
            // Kiểm tra xem đường dẫn hiện tại có chứa đường dẫn của liên kết không
            if (currentPath.indexOf(linkPath) !== -1) {
                $(this).addClass("aside__navbar_item__link--active");
                // $(this).closest('.aside__navbar_item').addClass("aside__navbar_item__link--active");
            }
        });
    })
 </script>
</body>
</html>
