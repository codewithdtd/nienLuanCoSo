<?php 
require_once 'connect.php';
require_once 'user.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $check_user = 'SELECT * FROM test.user WHERE phone_number = :phone';
    // Check user phone
    $statement = $conn->prepare($check_user);
    $statement->bindParam(':phone', $_POST['phone']);
    $statement->execute();
    $data = $statement -> fetch(PDO::FETCH_ASSOC);
    if($data) {
        $error_message = 'Số điện thoại đã được đăng ký!';
        $_SESSION["error_message"] = $error_message;
        header('Location: ../register.php');
    }
    else 
    {
    $add_user = 'INSERT INTO test.user(fullname, birthday, email, phone_number, address, password) VALUES (?, ?, ?, ?, ?, ?)';
    try {
        $statement = $conn->prepare($add_user);
        $statement->execute([
            $_POST['fullname'],
            $_POST['birthday'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['password']
        ]);
        
        $success_register = "Đăng ký tài khoản thành công";
        $_SESSION["success_message"] = $success_register;
        
        require_once 'user.php';
        $user = new User($conn);
        $user->fill($_POST);
        echo $user->getFulltName();
        header('Location:../login.html');
        exit();

    } catch (PDOException $e) {
        $pdo_error = $e->getMessage();
        echo 'Line: '. $e -> getLine();
    }
    }
}
?>
