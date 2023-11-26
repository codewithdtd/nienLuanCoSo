<?php 
require_once 'connect.php';

$sql = $conn->prepare('SELECT * FROM category');
$sql->execute();
$danhmuc = $sql->fetchAll(PDO::FETCH_ASSOC);


if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['name'])){
    $statement = $conn->prepare('INSERT INTO category(name) VALUES (?)');
    $statement->execute([$_POST['name']]);
    echo "<script>window.location='admin.php?nav=category';</script>";
}



// tìm kiếm
if( isset($_POST['search']) ) {
    // $products = (object)$products;
            $statement = $conn->prepare('SELECT * FROM ocake.category where name like ?');
            $statement->execute(['%'.$_POST['search'].'%']);
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);
            $danhmuc = $row;

}

// sắp xếp
if(isset($_POST['sort'])) {

        if($_POST['sort_type'] == 'asc')
            $sapxep = "SELECT * FROM category ORDER BY name ASC";
        else
            $sapxep = "SELECT * FROM category ORDER BY name DESC";
    $stmt = $conn->prepare($sapxep);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $danhmuc = $row;
}


?>

<form action="" method="post" class="offset-2 col-sm-10 py-2">
    <input type="text" name="search" class="h-100 col-sm-5 search" placeholder="Tìm kiếm theo tên">
    <button class="btn btn-danger">Tìm kiếm</button>
</form>
<form action="" method="post" class="offset-2 col-sm-10 py-2">
    <select class="h-100 col-auto" name="sort_type">
        <option value="desc">Cao xuống thấp</option>
        <option value="asc">Thấp lên cao</option>
    </select>
    <button class="btn btn-danger" name="sort">Sắp xếp</button>
</form>


<div class="col-sm-10 offset-2 products">
    <h2>Danh mục</h2>
    <div class="d-flex justify-content-between">
        <a class="products_add">+ Thêm mới</a>
    </div>
    <ul class="products__title row">
        <li class="col-sm-1">STT</li>
        <li class="col-sm-6">Tên</li>
        <li class="col-sm-3">Tổng số sản phẩm</li>
    </ul>
    <?php $stt = 0;
    if($danhmuc != null)
    foreach($danhmuc as $list_item): ?>
        <div class="products__list row">
            <div class="col-sm-1 products__list__item border"><?php $stt+=1; echo $stt; ?></div>
            <div class="col-sm-6 products__list__item border"><?php echo htmlspecialchars($list_item['name']) ?></div>
            <div class="col-sm-3 products__list__item border">
                <?php
                if($danhmuc != null){
                    $sql = $conn->prepare('SELECT * FROM product WHERE category = ?');
                    $sql->execute([$list_item['name']]);
                    $soluong = $sql->fetchAll(PDO::FETCH_ASSOC);
                    echo count($soluong);
                }
                ?>
            </div>
            <div class="col-sm-2 products__list__action" style="flex-direction:row;">
                <form method="post" action="delete.php" class="my-3">
                    <div class="products__list__action__delete">
                        <input type="hidden" value="<?= htmlspecialchars($list_item['id'])?>" name="id_category">
                        <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<div id="add" class="modal fade row" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm danh mục mới</h4>
                <button type="button" class="close btn btn-outline-danger" data-bs-dismiss="modal">
                    <span>X</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form method="post">
                    <input type="text" name="name" class="w-100 my-3" placeholder="Nhập tên danh mục mới" required>
                    <button class="btn btn-success">Thêm</button>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button> -->
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // Xử lý sự kiện khi nút "Thêm giỏ hàng" được click
        $('.products_add').on('click', function() {
            // Hiển thị form
            // e.preventDefault();
            $('#add').modal('show');
        })
    });
    
</script>
