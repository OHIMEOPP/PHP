<?php 
    @session_start();
    $host = "other-mysql";
    $userAccount = "root";
    $userPassword = "J9012015";
    $dbName = "my_db";
    $chrs = "utf8mb4";
    $attr = "mysql:host=$host;dbname=$dbName;charset=$chrs";
//   echo $host;
    
    $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    // phpinfo();
    try{
        $link = new PDO($attr,$userAccount,$userPassword,$opts);
    }catch(PDOException $e){
        throw new PDOException($e->getMessage(),(int)$e->getCode());
    }
    // $sql = "SELECT * FROM ust8";

    // $_SESSION['link'] = new mysqli($host,$userAccount,$userPassword,$dbName); 
    // $link = $_SESSION['link'];
    // if($link -> connect_error){
    //     echo '無法連接資料庫 : ' . $link -> connect_error;
    //     die("Connection failed: " . $link->connect_error);
    // }else{
    //     $link->set_charset("utf8");
    //     // mysqli_select_db($dbName,$link);
    //     if($link){
    //     //    echo " 已連接正確資料庫 : " . $dbName;
    //     }
    //     else{
    //         // echo '無法連接正確資料庫 : ';
    //     }
    // }
    // mysqli_close($link);
?>