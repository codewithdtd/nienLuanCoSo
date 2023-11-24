<?php 
session_start();
require_once 'product_class.php';
require_once 'gallery.php';
$product = new Product($conn);
$gallerys = new Gallery($conn);

$categorys = $product->getCategory();

if(isset($_GET['category'])) {
    $statement = $conn->prepare('SELECT * FROM ocake.product WHERE category like ?');
    $statement->execute(['%'.$_GET['category'].'%']);
    while ($row = $statement->fetch()) {
        $pd = new Product($conn);
        $pd->fillFromDB($row);
        $list[] = $pd;
    }
}
else {
    $list = $product->getAllProducts();
}
$list_gallery = $gallerys->getAllGallery();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16"  href="image/favicons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">
    <title>Sản phẩm</title>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <!-- main -->
    <main>
        <div class="aside">
            <h3>Danh mục</h3>
            <ul class="aside__list">
                <li class="aside__list__item">
                    <a href="product.php" class="aside__list__item__link">Tất cả</a>
                </li>
            <?php foreach($categorys as $category): ?>
                <li class="aside__list__item">
                    <a href="product.php?category=<?= $category['name'] ?>" class="aside__list__item__link"><?= $category['name'] ?></a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <div class="product">
            <?php foreach($list as $list_item): ?>
                <form action="add_cart.php" method="post" class="form">
                    <?php 
                        if(isset($user)) 
                            echo '<input type="hidden" name="id_user" value="'.$user->getId().'">';
                    ?>
                    <div class="product__items">
                        <input type="hidden" name="id_product" value="<?= $list_item->getID() ?>">
                        <div class="product__items__img">
                            <?php 
                                $firstImg = null;
                                foreach($list_gallery as $imgs) 
                                    if ($imgs->product_id == $list_item->getID() && $firstImg === null) 
                                        $firstImg = $imgs->thumbnail;
                                echo '<a href="product_detail.php?id='.$list_item->getID().'"><img src="'.$firstImg.'" alt=""></a>
                                    <input type="hidden" name="img" value="'.$firstImg.'">';
                                ?>
                        </div>    
                        <h3 class="product__items__name"><?= htmlspecialchars($list_item->getName()) ?></h3>
                        <input type="hidden" name="name" value="<?= $list_item->getName() ?>">
                        <div class="product__items__info">
                            <div class="product__items__size">
                                <input type="checkbox" class="product__items__size--select" id="size" name="priceS" value="<?= htmlspecialchars($list_item->priceS) ?>">
                                <label for="size--s">S 
                                    <span class="product__items__price product__items__price--s"><?= htmlspecialchars(number_format($list_item->priceS,0,',','.')) ?></span>
                                </label>
                            </div>
                            <div class="product__items__size">
                                <input type="checkbox" class="product__items__size--select" id="size" name="priceM" value="<?= htmlspecialchars($list_item->priceM) ?>">
                                <label for="size--m">M
                                    <span class="product__items__price product__items__price--m"><?= htmlspecialchars(number_format($list_item->priceM,0,',','.')) ?></span>
                                </label>
                            </div>
                            <div class="product__items__size">
                                <input type="checkbox" class="product__items__size--select" id="size" name="priceL" value="<?= htmlspecialchars($list_item->priceL) ?>">   
                                <label for="size--l">L
                                    <span class="product__items__price product__items__price--l"><?= htmlspecialchars(number_format($list_item->priceL,0,',','.')) ?></span>
                                </label>
                            </div>         
                        </div>
                     
                        <button class="product__items__submit">Thêm vào giỏ hàng</button>
                    </div>
                </form>
            <?php endforeach; ?>
        </div>
        
    </main>
    
    
    <!-- footer -->
    <footer>
        <div class="footer-info">
            <div class="footer">
                <h4 class="footer__title">Thông tin cửa hàng</h4>
                <ul class="footer__list">
                    <li>Địa chỉ: phường Xuân Khánh, quận Ninh Kiểu, thành phố Cần Thơ</li>
                    <li>Giờ mở cửa: 8h - 21h</li>
                    <li>Số điện thoại: 0123 456 789</li>
                    <li>Email: ohCakeBekery@cake.com</li>
                </ul>
            </div>
            <div class="footer">
                <h4 class="footer__title">Danh mục</h4>
                <ul class="footer__list">
                    <li>Trang chủ</li>
                    <li>Giới thiệu</li>
                    <li>Sản phẩm</li>
                    <li>Liên hệ</li>
                </ul>
            </div>
            <div class="footer">
                <h4 class="footer__title">Mạng xã hội</h4>
                <ul class="footer__list">
                    <li>
                        <i class="ri-facebook-circle-line"></i>
                        Facebook
                    </li>
                    <li>
                        <i class="ri-instagram-line"></i>
                        Instagram
                    </li>
                    <li>
                        <i class="ri-tiktok-line"></i>
                        Tiktok
                    </li>
                </ul>
            </div>
            <div class="footer">
                <h4>Phương thức thanh toán</h4>
                <div class="footer__paying">
                    <img src="image/thanh_toan/8543_13-06-2016_Tienmat_Icon_big-2.png" alt="" class="footer__paying-img">
                    <img src="image/thanh_toan/MoMo_Logo.png" alt="" class="footer__paying-img">
                    <img src="image/thanh_toan/Mastercard-logo.svg.png" alt="" class="footer__paying-img">
                    <img src="image/thanh_toan/visa-payment-card1873.jpg" alt="" class="footer__paying-img">
                </div>
            </div>
        </div>

        <div class="copyright">
            <p>Copyright &copy 2023, Cửa hàng bánh OCake</p>
        </div>
    </footer>
     
    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".form").submit(function(event) {
                <?php if(isset($user)) 
                        $check = 1;
                        else $check = 0; 
                ?>
                if(!<?= $check ?>){
                    alert("Vui lòng đăng nhập để mua sản phẩm!");
                    event.preventDefault();
                }

                else if(!$(".product__items__size--select").is(":checked")) {
                        alert("Vui lòng chọn size.");
                        event.preventDefault();
                    }
                else if($(".product__items__size--select:checked").length > 1) {
                    alert("Chỉ chọn 1 size.");
                    event.preventDefault();
                }
                else if($(".product__items__size--select").is(":checked")) {
                        alert("Thêm sản phẩm thành công!");
                    }
            });
         });
     </script>
</body>
</html>