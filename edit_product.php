<?php

require_once 'class/product_class.php';
require_once __DIR__.'/class/gallery.php';

$product = new Product($conn);
$gallery = new Gallery($conn);
$id = isset($_REQUEST['id']) ?
    filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;

$product->find($id);
$categorys = $product->getCategory();

$gallerys = $gallery->findGallery($id);

$imgs = $product->image_upload();
$product->addGalleryForProducts($id,$imgs);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($product->update($_POST)) {
        echo "<p class='offset-3 alert alert-success'>Thành công<p>";
        // echo "<meta http-equiv='refresh' content='3'>";
    }
    else 
        echo "<p class='offset-3 alert alert-danger'>Thất bại<p>";
}
?>


<span class="offset-3">
    <a href="admin.php?nav=sanpham" id="back" class="btn btn-primary">Quay lại</a>
</span>
<div class="offset-3">

    <h1>Chỉnh sửa sản phẩm</h1>
    <form method="post" class="product_form" enctype="multipart/form-data">
        <input required type="hidden" name="id" value="<?= $id ?>">
        <div class="product_form__items">
            <label for="name" class="col-sm-2">Tên bánh:</label>
            <input required type="text" name="name" class="product_form__items__name col-sm-5" value="<?= htmlspecialchars($product->getName()) ?>">
        </div>

        <div class="product_form__items">
            <label for="category" class="col-sm-2">Danh mục:</label>
            <select class="col-sm-5" id="category" name="category">
                <option value="<?php echo $product->category ?>"><?php echo $product->category ?></option>
                <?php foreach($categorys as $category): ?>
                <option value="<?= $category['name'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="product_form__items">
            <label for="priceS" class="col-sm-2">Giá size S:</label>
            <input required type="number" name="priceS" class="product_form__items__price col-sm-5" value="<?= htmlspecialchars($product->priceS) ?>">
        </div>
        <div class="product_form__items">
            <label for="priceM" class="col-sm-2">Giá size M:</label>
            <input required type="number" name="priceM" class="product_form__items__price col-sm-5" value="<?= htmlspecialchars($product->priceM) ?>">
        </div>
        <div class="product_form__items">
            <label for="priceL" class="col-sm-2">Giá size L:</label>
            <input required type="number" name="priceL" class="product_form__items__price col-sm-5" value="<?= htmlspecialchars($product->priceL) ?>">
        </div>
        
        <!-- <div class="product_form__items">
            <label for="status" class="col-sm-2">Số lượng:</label>
            <input required type="number" name="status" class="product_form__items__status col-sm-5" value="">
        </div> -->
        <div class="product_form__items">
            <label for="description" class="col-sm-2">Mô tả:</label>
            <input required type="text" name="description" class="product_form__items__description col-sm-5" value="<?= htmlspecialchars($product->getDesciption()) ?>">
        </div>
        <div class="product_form__items">
            <label for="image" class="col-sm-2">Hình ảnh:</label>
            <input type="file" name="image[]" class="product_form__items__image" accept="image/*" multiple>
        </div>
        <div class="image_review--one"></div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
    <?php if($gallerys)
         foreach ($gallerys as $image): ?>
        <form method="post" action="delete.php">
            <div class="image_review">
                <img src="<?= htmlspecialchars($image->thumbnail)?>" style="width:100px">
                <input required type="hidden" value="<?= htmlspecialchars($image->id)?>" name="id_img">
                <button type="submit" class="btn btn-danger">Xóa</button>
            </div>
        </form>
    <?php endforeach; ?>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function () {
            $('.product_form__items__image').on('change', function () {
                for (let i = 0; i < this.files.length; i++) {
                    let file = this.files[i];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            let thumbnail = '<img src="' + e.target.result + '" alt="Thumbnail" style="width:100px">';
                            $('.image_review--one').append(thumbnail);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        });
    </script>
    <script src="js/back.js"></script>