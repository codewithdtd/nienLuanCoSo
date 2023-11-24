<?php 
require_once __DIR__.'/user.php';

$user = new User($conn);

if (isset($_REQUEST['id'])) {
    $user->find($_REQUEST['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'  && isset($_POST['update'])) {
    if($user->update($_POST)) {
        echo "Thành công";
        echo "<meta http-equiv='refresh' content='0'>";
    }
    else 
        echo 'Thất bại';
}

?>


    <span class="offset-2">
        <a href="#" id="back">Quay lại</a>
    </span>
    <form method="post" class="offset-2 register-form col-10 text-center">
        <h1 class="register-form__title">Chỉnh sửa thông tin khách hàng</h1>
        
        <div class="register-form__input">
            <label for="fullname" class="col-sm-2 text-start">Họ tên:</label>
            <input required type="text" class="user__name col-sm-6" name="fullname" value="<?= htmlspecialchars($user->getFulltName()) ?>">
        </div>
        <div class="register-form__input">
            <label for="birthday" class="col-sm-2 text-start">Ngày sinh:</label>
            <input required type="date" class="user__birthday col-sm-6" name="birthday" value="<?= htmlspecialchars($user->getBirthDay()) ?>">
        </div>

        <div class="register-form__input">
            <label for="email" class="col-sm-2 text-start">Email:</label>
            <input required type="text" class="user__email col-sm-6" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>">
        </div>
        <div class="register-form__input">
            <label for="phone" class="col-sm-2 text-start">Số điện thoại:</label>
            <input required type="text" class="user__phone col-sm-6" name="phone" value="<?= htmlspecialchars($user->getPhone_number()) ?>">
        </div>           

        <div class="register-form__input">
            <label for="address" class="col-sm-2 text-start">Địa chỉ:</label>
            <input required type="text" class="user__address col-sm-6" name="address" value="<?= htmlspecialchars($user->getAddress()) ?>">
        </div>

        <button class="register-form__submit m-4" type="submit" name="update">Cập nhật</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/back.js"></script>
