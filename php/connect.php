<?php 
const _HOST = 'localhost';
const _DB = 'test';
const _USER = 'root';
const _PASS = '';

try {
    if(class_exists('PDO')){

        $dsn = 'mysql:dbname'._DB.';host='._HOST;

        $conn = new PDO($dsn,_USER,_PASS);
        
        if ($conn) {
            echo 'Kết nối thành công';
        }
    }
}
catch(Exception $exception) {
    echo $exception -> getMessage().'<br>';
    echo 'Line: '. $exception -> getLine();

    die();
}

?>
