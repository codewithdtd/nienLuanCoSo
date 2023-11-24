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
                        <a class="navbar-list__item-link navbar-list__item-link--active" href="index.php">TRANG CHỦ</a>
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
                            <span class="name_user"><?= htmlspecialchars($user->getFulltName())?></span>
                            <div class="user">
                               
                                <h4><?= htmlspecialchars($user->getFulltName()) ?> </h4>
                                <a href="info_user.php?id=<?= $id_user ?>">Chỉnh sửa tài khoản</a>
                                <a href="info_user.php?id=<?= $id_user ?>&act=show">Xem thông tin đơn hàng</a>
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
<script>
    $(document).ready(function () {
        $(".close_search").click(function () {
            $(".navbar__search__show").hide();
        });
       $('.navbar-list__item-link').click(function(){
            $(this).addClass('navbar-list__item-link--active');
       })
});
</script>