<?php
require_once 'function.php';

//-----------------
//如果接收查詢標籤名稱
if (isset($_GET['tag'])) {
    $inputtag = $_GET['tag'];

    //如果有選擇排序 傳入排序keyword與使用者id 沒則使用預設
    if (isset($_POST['select_sort'])) {
        $sel = selectsort($_POST['select_sort'], $user_id);
    } else {
        $sel = "SELECT * FROM `img_data`  WHERE `creat_user_id` = {$user_id}";
    }
    //取得圖片資料(或排序)
    $user = queryimgids($sel);

    if (isset($inputtag)) {
        //遍歷圖片資訊
        //取圖片所有圖片標籤 another tag 包括人物 團體 作者等
        foreach ($user as $row1 => $v) {
            //處理當下圖片標籤 another tag 以逗號分割
            $anotherTag =  explode(",", $user[$row1]['anotherTag']);

            array_push($anotherTag, $user[$row1]['mainTag']);
            array_push($anotherTag, $user[$row1]['secondaryTag']);
            array_push($anotherTag, $user[$row1]['ArtistTag']);

            //檢查當下圖片有沒有被查詢的tag 如果有 ，資訊填入陣列
            if (in_array($inputtag, $anotherTag)) {
                $tagsimg[] = array(
                    'anotherTag' => $anotherTag,
                    'img_path' => $user[$row1]['img_path'],
                    'id' => $user[$row1]['id'],
                    'check_img_type' => $user[$row1]['check_img_type'],
                    'mainTag' => $user[$row1]['mainTag'],
                    'secondaryTag' => $user[$row1]['secondaryTag'],
                    'ArtistTag' => $user[$row1]['ArtistTag']
                );
            }
        }
    }
}
//----------------
$sel = "SELECT * FROM `img_data`  WHERE `creat_user_id` = {$user_id}";

if (isset($_POST['select_sort'])) {
    $sel = selectsort($_POST['select_sort'], $user_id);
}

echo "<div class='content' id='content'>";

if (isset($tagsimg)) {
    imgdisplay($tagsimg, $inputtag);
    echo "<script>clr_dom()</script>";
}else if(empty( $tagsimg)){
    
} 
else {
    $user = queryimgids($sel);
    if ($user)
        imgdisplay($user, null);
}

echo "<div>";

// header("Location: indexTWO.php?are=frontpage");