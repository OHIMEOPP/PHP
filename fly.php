<?php
require_once 'function.php';

//-----------------
//如果接收查詢標籤名稱
if (isset($_GET['tag'])) {
    $inputtag = $_GET['tag'];
    $inputtagarray = explode(",", $inputtag);
    if (!empty($inputtagarray))
        $inputtagCut = '';
    foreach ($inputtagarray as $key) {
        // 將條件加入到字串
        $inputtagCut .= "anotherTag LIKE '%" . $key . "%'";

        // 如果當前的 $key 不是陣列中的最後一個元素，則加上 "&&"
        if ($key !== end($inputtagarray)) {
            $inputtagCut .= " && ";
        }
    }
    echo $inputtagCut;
    //如果有選擇排序 傳入排序keyword與使用者id 沒則使用預設
    if (isset($_POST['select_sort'])) {
        $sel = selectsort($_POST['select_sort'], $user_id, $inputtag);
        // $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id} && `anotherTag` LIKE '%$inputtag%' order by `id`;";
    } else {
        $sel = "SELECT * FROM `img_data`  WHERE `creat_user_id` = {$user_id}";
    }
    //取得圖片資料(或排序)
    $tagsimg = queryimgids($sel);
}
//----------------
$sel = "SELECT * FROM `img_data`  WHERE `creat_user_id` = {$user_id}";

if (isset($_POST['select_sort'])) {
    $sel = selectsort($_POST['select_sort'], $user_id, null);
}

echo "<div class='content' id='content'>";

if (isset($tagsimg) && !empty($inputtag)) {
    imgdisplay($tagsimg, $inputtag);
    echo "<script>clr_dom()</script>";
    // } elseif ($tagsimg == '甚麼都沒有啦') {
//     echo "沒有圖片喔";
//     echo $inputtag;
// }
} else {
    $user = queryimgids($sel);
    if ($user)
        imgdisplay($user, null);
}

echo "<div>";

// header("Location: indexTWO.php?are=frontpage");