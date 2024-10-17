<?php
require_once 'db.php';
require_once 'function.php';
// setcookie();
//mysqli搜尋 = 放到變數

$time = currentTime();
$_javaURL = "https://script.google.com/macros/s/AKfycbwbYeFHFeZCu0IIdCwbU5TzKGizQCgCLBElzDmz_EM5Z-oLSi4BAHFDMkBFnF2fDrRtgQ/exec";

$frontpage = "indexTWO.php?are=frontpage"; //https://ohimeopp.github.io/index/indexTWO.html
$loginpage = "./indexAcount.php"; //https://ohimeopp.github.io/index/index.html
// 檢查登入涵式
function login()
{
    global $link;
    global $frontpage; //https://ohimeopp.github.io/index/indexTWO.html
    global $loginpage; //https://ohimeopp.github.io/index/index.html

    $searchAccount = $_POST["account"]; // 要尋找的值
    $searchPassword = $_POST["password"]; // 要尋找的值

    $sel = $link->prepare("SELECT * FROM `user_account` WHERE `account`=? && `password`=?");
    $sel->bindParam(1, $searchAccount, PDO::PARAM_STR, 30);
    $sel->bindParam(2, $searchPassword, PDO::PARAM_STR, 30);

    $sel->execute([$searchAccount, $searchPassword]);

    $data = _select($sel);

    //將每一列的每個欄位給陣列$user
    if (!empty($data)) {
        foreach ($data as $row1) {
            $user = array(
                'id' => array(
                    $row1['id']
                ),
                'account' => array(
                    $row1['account']
                ),
                'password' => array(
                    $row1['password']
                )
            );
        }
        setcookie('is_login', "true", time() + 60 * 60 * 24, "/");
        if (empty($_COOKIE['uuid']))
            setcookie('uuid', uniqid(), time() + 60 * 60 * 24, "/");
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['select_sort'] = "ID";
        // header("Location: $frontpage");
    } else {
        $_SESSION['is_login'] = false;
        $_SESSION['msg'] = "登入失敗，請重新登入";
        // header("Location: $loginpage");
    }



    //釋放記憶體

}
function signUp()
{
    global $link;
    global $loginpage;
    global $time;
    $_SESSION['msg'] = '這號密碼需大於五位';

    $querySel = false;
    //要增加的帳密
    $check_img_type = array(
        'icon',
        'image',
        'Wimage'
    );

    $increaseAccount = $_POST['increaseaccount'];
    $increasePassword = $_POST['increasepassword'];
    if (strlen($increaseAccount) >= 5 && strlen($increasePassword) >= 5) {
        $sel = "INSERT INTO `user_account`(`account`, `password`, `name`) VALUES ('$increaseAccount','$increasePassword','jack')";
        $querySel = $link->query($sel);
        $new_user_id = queryAccount()['id'];
        // echo $_SESSION['msg'] = "asd";
        foreach ($check_img_type as $r) {
            $sel = "INSERT INTO `img_data`(`img_path`, `upload_date`, `creat_user_id`, `check_img_type`) 
            VALUES ('KV_smoke_2880.dd9c01d6.png','$time','$new_user_id','$r')";
            $querySel = $link->query($sel);
            echo $_SESSION['msg'] = "創建成功";
        }
        header("Location: $loginpage");
    } else {
        $_SESSION['msg'] = '帳號密碼需大於五位';
    } //page
    if ($querySel === false) {
        // 查询执行失败，处理错误
        // echo "Query failed: " . mysqli_error($link);
    } else {
        //釋放記憶體
        mysqli_free_result($querySel);
    }
    header("Location: $loginpage");
}

// 如果有設定號密欄位，就使用檢查登入涵是login()
if (!empty($_POST["account"]) && !empty($_POST["password"])) {
    login();
    // $_SESSION['msg'] = "lo";
} else if (!empty($_POST['increaseaccount']) && !empty($_POST['increasepassword'])) {
    signUp();
    // $_SESSION['msg'] = "sig";
}

?>
<a href="indexAcount.php">首頁</a>
<!DOCTYPE html>
<html>

<body>
    <img src="imag\photo_01.jpg">
</body>

</html>
<?php
// mysqli_close($link);
?>