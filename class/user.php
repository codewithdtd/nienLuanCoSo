<?php
require_once 'connect.php';
class User {

    protected ?PDO $connect;

    public $id;

    public $fullname;

    public $phone_number;
 
    public $email;

    public $birthday;

    public $password;

    public $address;

    public $created_at;

    public $updated_at;

    public $role_id;


    public function getId()
    {
        return $this->id;
    }

    public function getFulltName()
    {
        return $this->fullname;
    }
  
    public function getBirthDay()
    {
        return $this->birthday;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone_number()
    {
        return $this->phone_number;
    }

    public function getAddress()
    {
        return $this->address;
    }

    // Hàm xây dựng
    public function __construct(?PDO $conn)
    {
        $this->connect = $conn;
    }


    public function fill(array $data) {
        $this->fullname = $data['fullname'];
        $this->email = $data['email'];
        $this->phone_number = $data['phone_number'];
        $this->birthday = $data['birthday'];
        $this->password = $data['password'];
        $this->address = $data['address'];
        $this->created_at = date("G:i:s  d/m/y", time());
        $this->updated_at = date("G:i:s  d/m/y", time());
        $this->role_id = 0;
        return $this;
    }
    
    public function fillFromDB(array $row): User
    {
        [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'birthday' => $this->birthday,
            'password' => $this->password,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role_id' => $this->role_id
        ] = $row;
        return $this;
    }
    
// tìm kiếm
    public function find($id): ? User
    {
        $statement = $this->connect->prepare('SELECT * FROM ocake.user where id = :id');
        $statement->execute(['id' => $id]);
        
        if ($row = $statement->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }

        return null;
    }
    
    // phương thức chỉnh sửa 
    // public function updateUserInfo($newfullname, $newEmail, $newPhone_number, 
    //                             $newBirthDay, $newPassword, $newAddress) {
    //     $this->username = $newfullname;
    //     $this->email = $newEmail;
    //     echo "Thông tin người dùng đã được cập nhật.<br>";
    // }

    public function check_user($phone, $password){
        $statement = $this->connect->prepare('SELECT * FROM ocake.user WHERE phone_number = :phone AND password = :pass');
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':pass', $password);
        $statement->execute();
        $data = $statement -> fetch(PDO::FETCH_ASSOC);
        if($data) {
            $_SESSION['id_user'] = $data['id'];
            return $data['role_id'];
        }
    }

    
    public function getAllUser() {
        $statement = $this->connect->prepare('SELECT * FROM ocake.user');
        $statement->execute();

        while ($row = $statement->fetch()) {
            $user = new User($this->connect);
            $user->fillFromDB($row);
            if ($user->role_id != 1)
                $users[] = $user;
        }
        if(isset($users))
            return $users;
    }


    public function getUser($id) {
        $statement = $this->connect->prepare('SELECT * FROM ocake.user WHERE id = ?');
        $statement->execute([$id]);

        if ($row = $statement->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }


    public function check_register(){
        $check_user = 'SELECT * FROM ocake.user WHERE phone_number = :phone';
        // Check user phone
        $statement = $this->connect->prepare($check_user);
        $statement->bindParam(':phone', $_POST['phone']);
        $statement->execute();
        $data = $statement -> fetch(PDO::FETCH_ASSOC);
        if($data) {
            return false;
        }
        return true;
    }


    public function addUser() {
        if($this->check_register()) {
            $add_user = 'INSERT INTO ocake.user(fullname, birthday, email, phone_number, address, password) VALUES (?, ?, ?, ?, ?, ?)';
            try {
                $statement = $this->connect->prepare($add_user);
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
                
                // require_once 'user.php';
                // $user = new User($this->connect);
                // $this->fill($_POST);
                // $this->addOrder();
                header('Location:login.php');
                exit();

            } catch (PDOException $e) {
                $e->getMessage();
                echo 'Line: '. $e -> getLine();
            }
        
        }
        else {
            $error_message = 'Số điện thoại đã được đăng ký!';
            $_SESSION["error_message"] = $error_message;
        }
    }


    public function save(): bool
    {
        $result = false;
        $statement = $this->connect->prepare(
            'UPDATE ocake.user SET fullname = :fullname,
            birthday = :birthday, email = :email, phone_number = :phone_number,
            address = :address
            where id = :id'
            );
        $result = $statement->execute([
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'birthday' => $this->birthday,
            'address'=> $this->address,
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
        $statement = $this->connect->prepare('DELETE FROM ocake.user WHERE id = :id');
        return $statement->execute(['id' => $this->id]);
    }



    //Hoa don nguoi dung
    public function addOrder(){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $madonhang = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $madonhang = date('dmy').substr(str_shuffle($madonhang),0,8);

        $add_order = 'INSERT INTO ocake.orders(madonhang, user_id, fullname, phone_number, address, pay_type, total_money) 
                        VALUES (?, ?, ?, ?, ?, ?, ?) ';
        $statement = $this->connect->prepare($add_order);
        $statement->execute([
            $madonhang,
            $_POST['id_user'],
            $_POST['fullname'],
            $_POST['phone_number'],
            $_POST['address'],
            $_POST['pt'],
            $_POST['total_money']
        ]);

        $statement = $this->connect->prepare('SELECT * FROM ocake.orders');
        $statement->execute();
        while ($order = $statement->fetch()) {
            $orders = $order;
        }
        return $orders;
    }

    public function addcart($data){
        $find = 'SELECT * FROM ocake.cart WHERE product_id = :product_id and size = :size';
        $statement = $this->connect->prepare($find);
        $statement->execute([
            'product_id' => $data['id_product'],
            'size' => $data['size']
        ]);
        if ($order = $statement->fetch()) {
            $this->updateCart($order['id']);
        }
        else {
            $statement = $this->connect->prepare('SELECT * FROM ocake.orders');
            $order = $statement->execute();
            $add_orderDetail = 'INSERT INTO ocake.cart(user_id, product_id, image, name, size, num, price, total_money) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?) ';
            $statement = $this->connect->prepare($add_orderDetail);
            $statement->execute([
                $data['id_user'],
                $data['id_product'],
                $data['img'],
                $data['name'],
                $data['size'],
                $data['num'],
                $data['price'],
                $data['price']*$data['num']
            ]);
        }
    }

    public function findOrderDetail($product_id, $size) {
        $find = 'SELECT num FROM ocake.orders_details WHERE product_id = :product_id and size = :size';
        $statement = $this->connect->prepare($find);
        $statement->execute([
            'product_id' => $product_id,
            'size' => $size
        ]);
        if ($statement->fetch()) {
            $this->updateCart($statement);
            return true;
        }

    }

    public function updateCart($id){
        
        $update = 'UPDATE ocake.cart 
        SET num = num+1, total_money= price*num WHERE id = ? ';
        $statement = $this->connect->prepare($update);
        $statement->execute([$id]);
    }

    // public function updateId_OrderDetail($id_order, $id_user){
    //     $update = 'UPDATE ocake.cart 
    //     SET order_id = ? WHERE user_id = ? ';
    //     $statement = $this->connect->prepare($update);
    //     $statement->execute([$id_order, $id_user]);
    // }

    public function updateCartDecrease($id){
        $statement = $this->connect->prepare('SELECT * FROM ocake.cart WHERE id = ?');
        $statement->execute([$id]);
        if($order = $statement->fetch()) {
            if($order['num'] > 1) {
                $update = 'UPDATE ocake.cart 
                SET num = num-1, total_money= price*num WHERE id = ? ';
                $statement = $this->connect->prepare($update);
                $statement->execute([$id]);
            } 
        }
        
    }

    public function getAllCart($id_user){
        $statement = $this->connect->prepare('SELECT * FROM ocake.cart WHERE user_id=?');
        $statement->execute([$id_user]);

        while ($order = $statement->fetch()) {
            $orders[] = $order;
        }
        if(isset($orders))
            return $orders;
        else
            return null;
    }


    public function deleteCart($id) {
        $statement = $this->connect->prepare('DELETE FROM ocake.cart WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    public function deleteAllOrderDetail($id_order) {
        // $this->updateId_OrderDetail($id_order, $id_user);
        $statement = $this->connect->prepare('INSERT INTO ocake.order_details (SELECT * FROM ocake.cart WHERE order_id = ?)');
        $statement->execute([$id_order]);
        $statement = $this->connect->prepare('DELETE FROM ocake.cart WHERE order_id = ?');
        $statement->execute([$id_order]);
    }
}