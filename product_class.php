<?php
// session_start();
require_once 'connect.php';
require_once 'gallery.php';
class Product {

    protected ?PDO $connect;

    public $id;

    public $name;

    public $priceS;
    public $priceM;
    public $priceL;


    public $category;

    public $description;

    public $created_at;

    public $updated_at;


    public function getId()
    {
        return $this->id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getDesciption()
    {
        return $this->description;
    }
 
    // Hàm xây dựng
    public function __construct(?PDO $conn)
    {
        $this->connect = $conn;
    }

    public function fill(array $data) {
        $this->name = $data['name'];
        $this->category = $data['category'];
        $this->priceS = $data['priceS'];
        $this->priceM = $data['priceM'];
        $this->priceL = $data['priceL'];
        $this->description = $data['description'];
    }

    public function fillFromDB(array $row): Product
    {
        [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'priceS' => $this->priceS,
            'priceM' => $this->priceM,
            'priceL' => $this->priceL,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ] = $row;
        return $this;
    }
   
    public function image_upload() : array {
        $uploadedFiles = [];
    
        if(isset($_FILES['image']) && is_array($_FILES['image']['tmp_name'])) {
            $images = $_FILES['image'];
    
            $count = count($images['tmp_name']);

            for ($i = 0; $i < $count; $i++) {
                $tmpName = $images['tmp_name'][$i];
                $extension = pathinfo($images['name'][$i], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $destination = 'upload/' . $filename;

                if(move_uploaded_file($tmpName, $destination)){
                    $uploadedFiles[$i] = $destination;
                }
            }
        }
    
        return $uploadedFiles;
    }
    
    // them vao table product
    public function addProduct() {
        $add_product = 'INSERT INTO ocake.product(name, category, priceS, priceM, priceL, description) 
                            VALUES ( ?, ?, ?, ?, ?, ?)';
        $statement = $this->connect->prepare($add_product);
        $statement->execute([
            $_POST['name'],
            $_POST['category'],
            $_POST['priceS'],
            $_POST['priceM'],
            $_POST['priceL'],
            $_POST['description']
        ]);
        // echo 'Thêm thành công';
        $product_id = $this->connect->prepare('SELECT id FROM ocake.product WHERE name = ?');
        $product_id->execute([
            $_POST['name']
        ]);
        $data = $product_id->fetch();
        return $data['id'];
    }


    public function addGalleryForProducts($productId, $productImages) {
        $addGalery = 'INSERT INTO ocake.gallery (product_id, thumbnail) VALUES (?, ?)';
        $statement = $this->connect->prepare($addGalery);
    
        foreach ($productImages as $image) {
            $statement->execute([$productId, $image]);
        }
        // $_SESSION['success']='Thêm sản phẩm thành công';
    }
    

    public function getAllProducts() {
        $statement = $this->connect->prepare('SELECT * FROM ocake.product');
        $statement->execute();
        while ($row = $statement->fetch()) {
            $product = new Product($this->connect);
            $product->fillFromDB($row);
            $products[] = $product;
        }
        if(isset($products))
            return $products;
    }
    

    public function find($id): ? Product
    {
        $statement = $this->connect->prepare('SELECT * FROM ocake.product where id = :id');
        $statement->execute(['id' => $id]);
        
        if ($row = $statement->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }

        return null;
    }
    

    public function save(): bool
    {
        $result = false;
        $statement = $this->connect->prepare(
            'UPDATE ocake.product SET name = :name,
            category = :category,
            priceS = :priceS, priceM = :priceM, priceL = :priceL,
            description = :description ,updated_at = now()
            where id = :id'
            );
        $result = $statement->execute([
            'name' => $this->name,
            'category' => $this->category,
            'priceS' => $this->priceS,
            'priceM' => $this->priceM,
            'priceL' => $this->priceL,   
            'description' => $this->description,
            'id' => $this->id]); 
        return $result;
    }

    public function update(array $data): bool
    {
        $this->fill($data);
        if($this->save());
            return true;
    }

    public function delete(): bool
    {   
        $statement = $this->connect->prepare('DELETE FROM ocake.product WHERE id = :id');
        return $statement->execute(['id' => $this->id]);
    }


    public function getCategory() {
        $statement = $this->connect->prepare('SELECT * FROM ocake.category');
        $statement->execute();
        while ($row = $statement->fetch()) {
            $category[] = $row;
        }
        return $category;
    }
}