<?php
require_once 'connect.php';
class Gallery {
    protected ?PDO $connect;

    public $id;

    public $product_id;

    public $thumbnail;

    public function __construct(?PDO $conn)
    {
        $this->connect = $conn;
    }

    protected function fillFromDB(array $row): Gallery
    {
        [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'thumbnail' => $this->thumbnail
        ] = $row;
        return $this;
    }

    public function getAllGallery() {
        $statement = $this->connect->prepare('SELECT * FROM ocake.gallery');
        $statement->execute();
        while ($row = $statement->fetch()) {
            $gallery = new Gallery($this->connect);
            $gallery->fillFromDB($row);
            $gallerys[] = $gallery;
        }
        return $gallerys;
    }

    public function findGallery($id): bool|array{
            $statement = $this->connect->prepare('SELECT * FROM ocake.gallery WHERE product_id = :id');
            $statement->execute(['id'=>$id]);
            while ($row = $statement->fetch()) {
                $gallery = new Gallery($this->connect);
                if($gallery->fillFromDB($row))
                    $gallerys[] = $gallery;
            }
            if(isset($gallerys))
                return $gallerys;
            else
                return false; 

    }


    public function find($id){
        $statement = $this->connect->prepare('SELECT * FROM ocake.gallery WHERE id = :id');
        $statement->execute(['id'=>$id]);
        while ($row = $statement->fetch()) {
            $gallery = new Gallery($this->connect);
            $gallery->fillFromDB($row);
        }
        return $gallery;

    }

    
    public function update(array $data): bool
    {
        $this->fillFromDB($data);
        $result = false;
        $statement = $this->connect->prepare(
            'UPDATE ocake.gallery SET product_id = :product_id, thumbnail = :thumbnail
            where id = :id'
            );
        $result = $statement->execute([
            'product_id' => $this->product_id,
            'thumbnail' => $this->thumbnail,
            'id' => $this->id]); 
        return $result;
    }

    public function remove_image_upload($path):bool {
        if(!file_exists($path))
            return false;
        return unlink($path);
    }

    public function delete($path): bool
    {   
        $this->remove_image_upload($path);
        $statement = $this->connect->prepare('DELETE FROM ocake.gallery WHERE id = :id');
        return $statement->execute(['id' => $this->id]);
        
    }

    public function deleteProduct($gallery):bool {
        try {
            foreach($gallery as $img)
                $this->remove_image_upload($img->thumbnail);
            $deleteGallery = $this->connect->prepare('DELETE FROM ocake.gallery WHERE product_id = :product_id');
            return $deleteGallery->execute(['product_id' => $_POST['id_product']]);
        }
        catch(Exception $e) {
            $this->connect->rollBack();
            return false;
        }
    }


}