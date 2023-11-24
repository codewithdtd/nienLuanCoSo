<?php session_start(); ?>
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
<body>
    <?php require_once 'header.php'; ?>
<!-- Main -->
    <main class="home">
        <div class="home-body">
            <div class="home-left">
                <h1 class="home-left__title">bánh 
                    <span class="home-left__title home-left__title--strong">ngon</span>
                </h1>
                <h1 class="home-left__title">giá 
                    <span class="home-left__title home-left__title--strong">hạt dẻ</span>
                    </h1>
                <h1 class="home-left__title">ship 
                    <span class="home-left__title home-left__title--strong">hỏa tốc</span>
                </h1>
            
                <p class="home-left__info">
                    Chúng tôi mong muốn tạo ra những chiếc bánh đẹp, thơm ngon và phục vụ trà và cà phê chất lượng hàng đầu đi kèm. Đội ngũ thân thiện của chúng tôi hy vọng sẽ mang lại sự hài lòng cho khách hàng 100%
                </p>
                <button class="home-left__btn">
                    <a href="product.php">XEM SẢN PHẨM</a>
                </button>
            </div>
            <div class="home-right">
                <img src="image/homepage.png" alt="" class="home_img-cake">
                <img src="image/strawberry.png" alt="" class="home__img-strawberry-top">
                <img src="image/strawberry.png" alt="" class="home__img-strawberry-bottom">
            </div>
        </div>


        <div class="home__info">
            <p>Chào mừng bạn đến với OCake - Nơi Mua Bánh Trực Tuyến hoặc Tại Cửa Hàng.</p>
            <p>Tại OhCake, chúng tôi biết rằng việc cắn miếng bánh hảo hạng đầu tiên là khoảnh khắc của niềm hạnh phúc thuần khiết và đó là tất cả những gì chúng tôi hướng tới!              
                Chúng tôi là một cửa hàng bánh trực tuyến từng đoạt giải thưởng, chuyên tạo ra những chiếc Bánh kỷ niệm đẹp và ngon cho bất kỳ dịp nào, được giao tận London đến tận nhà bạn. Bánh Brownies, Bánh quy và Bánh nướng thịt băm mới nướng của chúng tôi thậm chí có thể được vận chuyển đến bất kỳ đâu tại Vương quốc Anh.
                Chúng tôi cũng cung cấp dịch vụ Tư vấn bánh cưới và đặt làm riêng để biến giấc mơ về chiếc bánh điên rồ nhất của bạn thành hiện thực!
                </br>Quán cà phê sáng sủa và hiện đại của chúng tôi ở Battersea là địa chỉ lý tưởng cho những người yêu thích bánh ngọt, bánh ngọt và cà phê, đồng thời là ngôi nhà của trải nghiệm Bánh không đáy độc đáo của chúng tôi. Tất cả các loại bánh ngọt và đồ ăn vặt của chúng tôi đều được làm thủ công từ đầu tại tiệm bánh trong nhà của chúng tôi. Bạn có thể xem điều kỳ diệu xảy ra qua cửa sổ lớn phía trước của chúng tôi, trong khi thưởng thức bánh ngọt và cà phê chất lượng của nhân viên pha chế tại khu vực tiếp khách ngoài trời của chúng tôi.
            </p>
            <p>Chúng tôi không chỉ là một chiếc bánh - chúng tôi là OhCake.</p>
        </div>
    </main>

    <footer>
        <div class="footer-info">
            <div class="footer">
                <h4 class="footer__title">Thông tin cửa hàng</h4>
                <ul class="footer__list">
                    <li>Địa chỉ: phường Xuân Khánh, quận Ninh Kiểu, thành phố Cần Thơ</li>
                    <li>Giờ mở cửa: 8h - 21h</li>
                    <li>Số điện thoại: 0123 456 789</li>
                    <li>Email: OCakeBekery@cake.com</li>
                </ul>
            </div>
            <div class="footer">
                <h4 class="footer__title">Danh mục</h4>
                <ul class="footer__list">
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="">Giới thiệu</a></li>
                    <li><a href="product.php">Sản phẩm</a></li>
                    <li><a href="contact.html">Liên hệ</a></li>
                </ul>
            </div>
            <div class="footer">
                <h4 class="footer__title">Mạng xã hội</h4>
                <ul class="footer__list">
                    <li>
                        <i class="ri-facebook-circle-line"></i>
                        Facebook: Tiệm bánh OCake
                    </li>
                    <li>
                        <i class="ri-instagram-line"></i>
                        Instagram: @tiembanhocake
                    </li>
                    <li>
                        <i class="ri-tiktok-line"></i>
                        Tiktok: @tiembanhocake
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
</body>
</html>