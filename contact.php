<?php
require_once 'connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $statement = $conn->prepare('INSERT INTO ocake.feedback(name,phone,note) VALUES (? ,? ,?)');
    $statement->execute([$_POST['name'],$_POST['phone'],$_POST['note']]);
    echo '<script>alert("Thành công");</script>';
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
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;700&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Liên hệ</title>
</head>
<body>
   <?php require_once 'header.php'; ?>
    <div class="container text-center" style="padding-top: 100px; background-color: rgb(228, 228, 228);">
        <form method="post">
            <h3>Liên hệ</h3>
            <div class="row m-3">
                <label for="name" class="col-3 text-end">Tên:</label>
                <input required type="text" name="name" class="col-6">
            </div>
            <div class="row m-3">
                <label for="phone" class="col-3 text-end">Số điện thoại:</label>
                <input required type="text" name="phone" class="col-6" minlength="10">
            </div>
            <div class="row m-3">
                <label for="note" class="col-3 text-end">Nội dung:</label>
                <textarea name="note" rows="5" class="col-6" maxlength="100" required></textarea>
            </div>
            <button class="btn btn-primary mb-4">Gửi</button>
        </form>
    </div>
    
    <?php require_once 'footer.php' ?>
    <script src="js/main.js"></script>
</body>
</html>