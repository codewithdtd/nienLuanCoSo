<?php 
session_start();
require_once 'product_class.php';
require_once 'gallery.php';

$product = new Product($conn);
$gallery = new Gallery($conn);

if(isset($_GET['id'])){
    $product->find($_GET['id']);
    $gallerys = $gallery->findGallery($_GET['id']);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/product_detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">
    <title>Chi tiết sản phẩm</title>
</head>
<body>
    <?php require_once 'header.php'; ?>
    <div class="back">
        <a href="product.php">Quay lại</a>
    </div>
    <form action="add_cart.php" method="post" class="form">
        <div class="product-detail">
            <div class="product-image">
                <?php $firstImg = null;
                    foreach ($gallerys as $image)
                        if ($firstImg === null) 
                            $firstImg = $image->thumbnail; 
                        echo '<img src="'.$firstImg.'" alt="Product Image" class="product-category__item--main">
                                <div class="product-category">
                                    <img src="'.$firstImg.'" alt="Product Image" class="product-category__item" id="2">
                                    <img src="'.$image->thumbnail.'" alt="Product Image" class="product-category__item" id="1">
                                    <input type="hidden" name="img" value="'.$firstImg.'">
                                </div>';
                ?>
            </div>
            <div class="product-info">
                <?php 
                    if(isset($user)) 
                        echo '<input type="hidden" name="id_user" value="'.$user->getId().'">';
                ?>
                <input type="hidden" name="id_product" value="<?= $product->getID() ?>">
                <h1 class="product-title"><?= $product->getName() ?></h1>
                <input type="hidden" name="name" value="<?= $product->getName() ?>">
                <p class="product-description"><?= $product->getDesciption() ?></p>
                <input type="checkbox" id="size" name="priceS" value="<?= htmlspecialchars($product->priceS) ?>">
                <span class="product-price">Size S: <?= $product->priceS ?> VNĐ</span></br>
                <input type="checkbox" id="size" name="priceM" value="<?= htmlspecialchars($product->priceM) ?>">
                <span class="product-price">Size M: <?= $product->priceM ?> VNĐ</span></br>
                <input type="checkbox" id="size" name="priceL" value="<?= htmlspecialchars($product->priceL) ?>">
                <span class="product-price">Size L: <?= $product->priceL ?> VNĐ</span></br>
                <button class="add-to-cart">Thêm vào giỏ hàng</button>
            </div>
        </div>
    </form>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".product-category__item").click(function () {
                var newSrc = $(this).attr("src");
                $(".product-category__item--main").attr("src", newSrc);
            });


            $(".form").submit(function(event) {
                <?php if(isset($user)) 
                        $check = 1;
                        else $check = 0; 
                ?>
                if(!<?= $check ?>){
                    alert("Vui lòng đăng nhập để mua sản phẩm!");
                    event.preventDefault();
                }

                else if(!$('#size:checked').length) {
                        alert("Vui lòng chọn size.");
                        event.preventDefault();
                    }
                else if($('#size:checked').length > 1) {
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
