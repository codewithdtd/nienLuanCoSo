<?php  
require_once 'header.php';
$user = new User($conn);

if (isset($_REQUEST['id'])) {
    $user->find($_REQUEST['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])) { 
    if($_POST['pass_old'] != $user->getPassword()) {
        $_SESSION['error'] = "Mật khẩu sai!";
    }
    else {
        $query = 'UPDATE ocake.user SET password = ? WHERE id = ?';
        $statement = $conn->prepare($query);
        $statement->execute([
            $_POST['pass_new'],
            $_REQUEST['id']
        ]);
    }
}
?>

    <form method="post" class="offset-2 change_password col-10">
    <?php if(isset($_SESSION['error']) ) {
            echo '<p class="alert alert-danger">'.$_SESSION['error'].'</p>';
            unset($_SESSION['error']); }
    ?>
        <h4>Đổi mật khẩu</h4>
        <div class="">
            <label for="pass_old" class="col-sm-2">Mật khẩu cũ:</label>
            <input type="text" class="pass_old col-sm-6" name="pass_old" value="" required>
        </div>
        <div class="">
            <label for="pass_new" class="col-sm-2">Mật khẩu mới:</label>
            <input type="password" class="pass_new col-sm-6" name="pass_new" value="" required>
        </div>
        <div class="">
            <label for="pass_new_confirm" class="col-sm-2">Xác nhận lại:</label>
            <input type="password" class="pass_new_confirm col-sm-6" name="pass_new_confirm" value="" required>
        </div>
        <button class="btn btn-primary" name="change">Cập nhật</button>
    </form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="js/validate_form.js"></script>
