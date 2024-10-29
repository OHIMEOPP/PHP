<?php
$host = "35.234.5.71"; // PostgreSQL 服務器地址
$userAccount = "tenparking"; // PostgreSQL 賬戶名稱
$userPassword = "parkitvip"; // PostgreSQL 密碼
$dbName = "test_parking_sql"; // PostgreSQL 數據庫名稱
$port = "5432"; // PostgreSQL 默認端口號
$chrs = "utf8"; // 字符集設置為 UTF-8
$attr = "pgsql:host=$host;port=$port;dbname=$dbName;options='--client_encoding=$chrs'";
echo 321;
try {
    // 創建 PDO 連接
    $link = new PDO($attr, $userAccount, $userPassword);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // 設置錯誤模式
    echo "成功連接到 PostgreSQL!";
} catch (PDOException $e) {
    // 捕獲錯誤
    echo "連接失敗: " . $e->getMessage();
}

$sel = "SELECT * FROM users";

$sel = $link -> prepare($sel);
$sel -> execute();

$date = $sel ->fetchAll(PDO::FETCH_ASSOC);
print_r($data);