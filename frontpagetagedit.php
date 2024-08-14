<?php
require_once 'function.php';

if (isset($_POST['check_tag_chose']) && isset($_POST['radio_tag_chose'])) {
    $type = $_POST['radio_tag_chose'][0];
    $check_tag_chose = $_POST['check_tag_chose'];
    foreach ($check_tag_chose as $v) {
        $_sel = "UPDATE `tag_data` SET `type`='$type' WHERE `tag_name`='$v'  && `creat_user_id` = {$user_id}";
        mysqli_query($link, $_sel);
    }
    // $sel = "SELECT * FROM `tag_data`  WHERE `creat_user_id` = {$user_id}";
    echo "<br>";
    print_r($type);
}
//增新分類情況
if (isset($_POST['edit_tagname']) && isset($_POST['add_tagtype']) && $_POST['edit_tagname'] != "" && $_POST['add_tagtype'] != "") {
    $edit_tagname = $_POST['edit_tagname'];
    $add_tagtype = $_POST['add_tagtype'];
    $oringlevalue = $_POST['backvalue'];
    $_sel = "UPDATE `tag_data` SET `type`='$add_tagtype' WHERE `tag_name`='$oringlevalue' && `creat_user_id` = {$user_id}";
    // mysqli_query($link, $_sel);
    $link->query($_sel);
    echo "現在是增新分類情況" . "<br>";
    if ($edit_tagname != $oringlevalue){
        $_sel = "UPDATE `tag_data` SET `tag_name`='$edit_tagname' WHERE `tag_name`='$oringlevalue' && `creat_user_id` = {$user_id}";
        // mysqli_query($link, $_sel);
        $link->query($_sel);
        echo "現在是增新分類情況 加上 有更新標籤名稱" . "<br>";
    }
}//選擇分類情況 
else if (isset($_POST['edit_tagname']) && isset($_POST['radio_tag_chose'])) {
    $edit_tagname = $_POST['edit_tagname'];
    $radio_tag_chose = $_POST['radio_tag_chose'][0];
    $oringlevalue = $_POST['backvalue'];
    $_sel = "UPDATE `tag_data` SET `type`='$radio_tag_chose' WHERE `tag_name`='$oringlevalue' && `creat_user_id` = {$user_id}";
    $link->query($_sel);
    echo "現在是選擇分類情況" . "<br>";
    if ($edit_tagname != $oringlevalue){
        $_sel = "UPDATE `tag_data` SET `tag_name`='$edit_tagname' WHERE `tag_name`='$oringlevalue' && `creat_user_id` = {$user_id}";
        $link->query($_sel);
        echo "現在是選擇分類情況 加上 有更新標籤名稱" . "<br>";
    }
   
}
header("Location: indexTWO.php?are=frontpage");
