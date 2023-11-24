<?php  
require_once __DIR__.'/class/user.php';
$user = new User($conn);
$users = $user->getAllUser();

// tìm kiếm
if( isset($_POST['search']) ) {
    // $products = (object)$products;
    switch ($_POST['search-type']) {
        case 'name-search':
            $statement = $conn->prepare('SELECT * FROM ocake.user where fullname like ? AND fullname <> "admin" ');
            $statement->execute(['%'.$_POST['search'].'%']);
            $row = $statement->fetchAll(PDO::FETCH_OBJ);
            $users = $row;
            break;

        case 'phone-search': 
            $statement = $conn->prepare('SELECT * FROM ocake.user where phone_number like ? AND fullname <> "admin" ');
            $statement->execute(['%'.$_POST['search'].'%']);
            $row = $statement->fetchAll(PDO::FETCH_OBJ);
            $users = $row;
            break;
    }
}


// sắp xếp

if(isset($_POST['sort'])) {
    if($_POST['sort_name'] == 'name')
        if($_POST['sort_type'] == 'asc')
            $sapxep = "SELECT * FROM user WHERE fullname <> 'admin' ORDER BY fullname ASC";
        else
            $sapxep = "SELECT * FROM user WHERE fullname <> 'admin' ORDER BY fullname DESC";
    if($_POST['sort_name'] == 'day')
        if($_POST['sort_type'] == 'asc')
            $sapxep = "SELECT * FROM user WHERE fullname <> 'admin' ORDER BY birthday ASC";
        else
            $sapxep = "SELECT * FROM user WHERE fullname <> 'admin' ORDER BY birthday DESC";
    $stmt = $conn->prepare($sapxep);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_OBJ);
    $users = $row;
}


?>




    <form action="" method="post" class="offset-2 col-sm-10 py-2">
        <input type="text" name="search" class="h-100 col-sm-5 search" placeholder="Tìm kiếm theo">
        <select class="h-100 col-2" name="search-type">
            <option value="name-search">Tên</option>
            <option value="phone-search">Số điện thoại</option>
        </select>
        <button class="btn btn-danger">Tìm kiếm</button>
    </form>
    <form action="" method="post" class="offset-2 col-sm-10 py-2">
        <select class="h-100 col-auto" name="sort_name">
            <option value="name">Tên</option>
            <option value="day">Ngày sinh</option>
        </select>
        <select class="h-100 col-auto" name="sort_type">
            <option value="desc">Cao xuống thấp</option>
            <option value="asc">Thấp lên cao</option>
        </select>
        <button class="btn btn-danger" name="sort">Sắp xếp</button>
    </form>
    <h4 class="text-center">Khách hàng</h4>
    <div class="col-sm-10 offset-2 products">
        <ul class="products__title row">
            <li class="col-sm-1">STT</li>
            <li class="col-sm-1">Họ tên</li>
            <li class="col-sm-2">SĐT</li>
            <li class="col-sm-3">Email</li>
            <li class="col-sm-2">Ngày sinh</li>
            <li class="col-sm-2">Địa chỉ</li> 
        </ul>
    <?php $stt = 0;
        if(isset($users))
            foreach($users as $user): ?> 
        <div class="products__list row">
            <div class="col-sm-1 products__list__item border"><?php $stt+=1; echo $stt; ?></div>
            <div class="col-sm-1 products__list__item border"><?php echo htmlspecialchars($user->fullname) ?></div>
            <div class="col-sm-2 products__list__item border"><?php echo htmlspecialchars($user->phone_number) ?></div>
            <div class="col-sm-3 products__list__item border"><?php echo htmlspecialchars($user->email) ?></div>
            <div class="col-sm-2 products__list__item border"><?php echo htmlspecialchars($user->birthday) ?></div>
            <div class="col-sm-2 products__list__item border"><?php echo htmlspecialchars($user->address) ?></div>
            <div class="col-sm-1 products__list__action">
                <div>
                    <a href="<?= 'admin.php?nav=suakhachhang&id='.htmlspecialchars($user->id)?>" class="btn btn-warning"><i class="ri-edit-line"></i></a>
                
                    <form method="post" action="delete.php">
                        <div class="products__list__action__delete">
                            <input type="hidden" value="<?= htmlspecialchars($user->id)?>" name="id_user">
                            <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>




