<?php
require_once 'connect.php';
class User {

    protected ?PDO $connect;

    protected $id;

    protected $fullname;

    protected $phone_number;
 
    protected $email;

    protected $birthdate;

    protected $password;

    protected $address;

    protected $created_at;

    protected $updated_at;

    protected $role_id;


    public function getId()
    {
        return $this->id;
    }

    public function getFulltName()
    {
        return $this->fullname;
    }
  
    public function getBirthDate()
    {
        return $this->birthdate;
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

    public function getAddressr()
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
        $this->phone_number = $data['phone'];
        $this->birthdate = $data['birthday'];
        $this->password = $data['password'];
        $this->address = $data['address'];
        $this->created_at = date("G:i:s  d/m/y", time());
        $this->updated_at = date("G:i:s  d/m/y", time());
        $this->role_id = 0;
    }
    
    // phương thức chỉnh sửa 
    // public function updateUserInfo($newfullname, $newEmail, $newPhone_number, 
    //                             $newBirthDate, $newPassword, $newAddress) {
    //     $this->username = $newfullname;
    //     $this->email = $newEmail;
    //     echo "Thông tin người dùng đã được cập nhật.<br>";
    // }

    public function check_user($phone, $password){
        $statement = $this->connect->prepare('SELECT * FROM test.user WHERE phone_number = :phone AND password = :pass');
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':pass', $password);
        $statement->execute();
        $data = $statement -> fetch(PDO::FETCH_ASSOC);
        if($data)
            return $data['role_id'];
    }

    // public function add_user(array $data){
    //     session_start();
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    //         $check_user = 'SELECT * FROM test.user WHERE phone_number = :phone';
    //         // Check user phone
    //         $statement = $this->connect->prepare($check_user);
    //         $statement->bindParam(':phone', $_POST['phone']);
    //         $statement->execute();
    //         $data = $statement -> fetch(PDO::FETCH_ASSOC);
    //         if($data) {
    //             $error_message = 'Số điện thoại đã được đăng ký!';
    //             $_SESSION["error_message"] = $error_message;
    //             header('Location: ../register.php');
    //         }
    //         else 
    //         {
    //             $add_user = 'INSERT INTO test.user(fullname, birthday, email, phone_number, address, password) VALUES (?, ?, ?, ?, ?, ?)';
    //             try {
    //                 $statement = $this->connect->prepare($add_user);
    //                 $statement->execute([
    //                     $_POST['fullname'],
    //                     $_POST['birthday'],
    //                     $_POST['email'],
    //                     $_POST['phone'],
    //                     $_POST['address'],
    //                     $_POST['password']
    //                 ]);
                    
    //                 $success_register = "Đăng ký tài khoản thành công";
    //                 $_SESSION["success_message"] = $success_register;
                    
    //                 $this->fill($_POST);
    //                 echo $this->getFulltName();
    //                 header('Location:../login.html');
    //                 exit();

    //             } catch (PDOException $e) {
    //                 $pdo_error = $e->getMessage();
    //                 echo 'Line: '. $e -> getLine();
    //             }
    //         }
    //     }
    // }
}