<?php 
require_once 'class/product_class.php';
require_once 'class/gallery.php';

if(isset($_SESSION['success'])){
    echo '<p class="offset-3 success_message">'.$_SESSION['success'].'</p>';
    unset($_SESSION['success']);
    // echo "<meta http-equiv='refresh' content='0'>";
}

$products = new Product($conn);
$list = $products->getAllProducts();
$gallerys = new Gallery($conn);
$list_gallerys = $gallerys->getAllGallery();
$categorys = $products->getCategory();
// tìm kiếm
if( isset($_POST['search']) ) {
    // $products = (object)$products;
    switch ($_POST['search-type']) {
        case 'name-search':
            $statement = $conn->prepare('SELECT * FROM ocake.product where name like ?');
            $statement->execute(['%'.$_POST['search'].'%']);
            $row = $statement->fetchAll(PDO::FETCH_OBJ);
            $list = $row;
            break;

        case 'category-search': 
            $statement = $conn->prepare('SELECT * FROM ocake.product where category like ?');
            $statement->execute(['%'.$_POST['search'].'%']);
            $row = $statement->fetchAll(PDO::FETCH_OBJ);
            $list = $row;
            break;
    }
}


// Lọc
if(isset($_POST['category'])) {
    $statement = $conn->prepare('SELECT * FROM ocake.product WHERE category like ?');
    $statement->execute(['%'.$_POST['category'].'%']);
    $row = $statement->fetchAll(PDO::FETCH_OBJ);
    $list = $row;
}

if(isset($_POST['sort'])) {
    if($_POST['sort_name'] == 'price')
        if($_POST['sort_type'] == 'asc')
            $sapxep = "SELECT * FROM product ORDER BY priceS ASC";
        else
            $sapxep = "SELECT * FROM product ORDER BY priceS DESC";
    if($_POST['sort_name'] == 'status')
        if($_POST['sort_type'] == 'asc')
            $sapxep = "SELECT * FROM product ORDER BY status ASC";
        else
            $sapxep = "SELECT * FROM product ORDER BY status DESC";
    $stmt = $conn->prepare($sapxep);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_OBJ);
    $list = $row;
}


?>

<form action="" method="post" class="offset-2 col-sm-10 py-2">
    <input type="text" name="search" class="h-100 col-sm-5 search" placeholder="Tìm kiếm theo">
    <select class="h-100 col-2" name="search-type">
        <option value="name-search">Tên</option>
        <option value="category-search">Danh mục</option>
    </select>
    <button class="btn btn-danger">Tìm kiếm</button>
</form>
<form action="" method="post" class="offset-2 col-sm-10 py-2">
    <select class="h-100 col-auto" name="sort_name">
        <option value="price">Giá</option>
        <option value="status">Số lượng</option>
    </select>
    <select class="h-100 col-auto" name="sort_type">
        <option value="desc">Cao xuống thấp</option>
        <option value="asc">Thấp lên cao</option>
    </select>
    <button class="btn btn-danger" name="sort">Sắp xếp</button>
</form>


<div class="col-sm-10 offset-2 products">
    <div class="d-flex justify-content-between">
        <a class="products_add" href="admin.php?nav=themsanpham">+ Thêm sản phẩm mới</a>
        <form class="product_form__items h-100" method="post">
            <label for="category" class="">Danh mục:</label>
            <select class="h-100 p-1" id="category" name="category">
                <option value="">Tất cả</option>
                <?php foreach($categorys as $category): ?>
                <option value="<?= $category['name'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" class="btn-danger" value="Lọc">
        </form>
    </div>
    <ul class="products__title row">
        <li class="col-sm-1">STT</li>
        <li class="col-sm-1">Tên</li>
        <li class="col-sm-1">Danh mục</li>
        <li class="col-sm-1">Giá size S</li>
        <li class="col-sm-1">Giá size M</li>
        <li class="col-sm-1">Giá size L</li>
        <li class="col-sm-3">Mô tả</li> 
        <li class="col-sm-2">Hình ảnh</li>    
    </ul>
    <?php $stt = 0;
    foreach($list as $list_item): ?>
        <div class="products__list row">
            <div class="col-sm-1 products__list__item border"><?php $stt+=1; echo $stt; ?></div>
            <div class="col-sm-1 products__list__item border"><?php echo htmlspecialchars($list_item->name) ?></div>
            <div class="col-sm-1 products__list__item border"><?php echo htmlspecialchars($list_item->category) ?></div>
            <div class="col-sm-1 products__list__item border pb-3">
                <p><?php echo htmlspecialchars(number_format($list_item->priceS)) ?></p>
            </div>
            <div class="col-sm-1 products__list__item border pb-3">
                <p><?php echo htmlspecialchars(number_format($list_item->priceM))?></p>
            </div>
            <div class="col-sm-1 products__list__item border pb-3">
                <p><?php echo htmlspecialchars(number_format($list_item->priceL)) ?></p>
            </div>
            <div class="col-sm-3 products__list__item products__list__item__description"><?php echo htmlspecialchars($list_item->description) ?></div>
            <div class="col-sm-2 products__list__item border">
                <?php 
                    foreach($list_gallerys as $list_gallery): 
                ?>
                    <?php if ($list_gallery->product_id == $list_item->id): ?>
                        <?php echo '<img class="col-sm-5" src="'.$list_gallery->thumbnail.'" width=25>' ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="col-sm-1 products__list__action">
                <button class="products__list__action__edit btn btn-warning">
                    <a href="<?= 'admin.php?nav=suasanpham&id='.htmlspecialchars($list_item->id)?>"><i class="ri-edit-line"></i></a>
                </button>
                <form method="post" action="delete.php">
                    <div class="products__list__action__delete">
                        <input type="hidden" value="<?= htmlspecialchars($list_item->id)?>" name="id_product">
                        <button type="submit" class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

