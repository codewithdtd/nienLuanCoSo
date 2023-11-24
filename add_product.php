<?php 
require_once 'connect.php';
require_once 'class/product_class.php';

$product = new Product($conn);
$categorys = $product->getCategory();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_product = $product->addProduct();
    $imgs = $product->image_upload();
    $product->addGalleryForProducts($id_product,$imgs);
    $product->fill($_POST);
    if(isset($_SESSION['success'])){
        echo '<p class="offset-3 success_message">'.$_SESSION['success'].'</p>';
        unset($_SESSION['success']);
    }
  
}   

?>
<span class="offset-3">
    <a href="admin.php?nav=sanpham" id="back" class="btn btn-primary">Quay lại</a>
</span>
<div class="offset-sm-3">
    <h2>Thêm sản phẩm</h2>
    <form method="post" class="product_form" enctype="multipart/form-data">
        <div class="product_form__items">
            <label for="name" class="col-sm-2">Tên bánh:</label>
            <input type="text" name="name" class="product_form__items__name col-sm-5">
        </div>

        <div class="product_form__items">
            <label for="category" class="col-sm-2">Danh mục:</label>
            <select class="col-sm-5" id="category" name="category">
                <?php echo var_dump($product) ?>
                <?php foreach($categorys as $category): ?>
                <option value="<?= $category['name'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>



        <div class="product_form__items">
            <label for="priceS" class="col-sm-2">Giá size S:</label>
            <input type="number" name="priceS" class="product_form__items__price col-sm-5" required>
        </div>
        <div class="product_form__items">   
            <label for="priceM" class="col-sm-2">Giá size M:</label>
            <input type="number" name="priceM" class="product_form__items__price col-sm-5" required>
        </div>
        <div class="product_form__items">    
            <label for="priceL" class="col-sm-2">Giá size L:</label>
            <input type="number" name="priceL" class="product_form__items__price col-sm-5" required>
        </div>

        <div class="product_form__items product_form__items__descripton">
            <label for="description" class="col-sm-2">Mô tả:</label>
            <input type="text" name="description" class="product_form__items__description col-sm-5" required>
        </div>
        <div class="product_form__items">
            <label for="image" class="col-sm-2">Hình ảnh:</label>
            <input type="file" name="image[]" class="product_form__items__image col-sm-5" required accept="image/*" multiple>
        </div>
        <div class="image_review"></div>
        <button type="submit" class="btn btn-primary">Đăng tải</button>
    </form>
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
                            let thumbnail = '<img src="' + e.target.result + '" alt="Thumbnail" style="width:150px">';
                            // let productFormItems = $('<div class="product_form__items">' +
                            //     '<label for="image">Hình ảnh:</label>' +
                            //     '<input type="file" name="image" class="product_form__items__image" accept="image/*" multiple>' +
                            //     '</div>');
                            // productFormItems.find('.product_form__items__image').on('change', function () {
                            //     // Add your change event logic here if needed.
                            // });
                            // productFormItems.find('.product_form__items__image').prop('files', this.files); // Copy selected files
                            // $('.image_review').append(productFormItems);
                            // productFormItems.append(thumbnail);
                            $('.image_review').append(thumbnail);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        });
    </script>
  
