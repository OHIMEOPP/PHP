<?php
require_once 'function.php';
ob_start();
//檢查有沒有設定tag
if (isset($_POST['set_maintag']) || isset($_POST['set_secondarytag']) || isset($_POST['set_artisttag']) || isset($_POST['set_anothertag'])) :

    $img_id = $_POST['imgid'];
    $main_tag = $_POST['set_maintag'];
    $second_tag = $_POST['set_secondarytag'];
    $artist_tag = $_POST['set_artisttag'];
    $source = $_POST['set_source'];
    $another_tag = $_POST['set_anothertag'];
    if (isset($_POST['img_status']))
                $img_status = $_POST['img_status'];
            else
                $img_status = 'public';

    $_POST['set_maintag'] = null;
    $_POST['set_secondarytag'] = null;
    $_POST['set_artisttag'] = null;
    $_POST['set_anothertag'] = null;
    $_POST['img_status'] = null;

    $time = currentTime();

    $check = '';
    $check = true;
    $sel = $link->prepare("UPDATE `img_data` SET `mainTag`=?,`secondaryTag`=?,`ArtistTag`=?,`anotherTag`=?,`ispublic`=?,`source`=? WHERE `id`='$img_id'");
    $sel->bindParam(1, $main_tag,       PDO::PARAM_STR, 128);
    $sel->bindParam(2, $second_tag,     PDO::PARAM_STR, 128);
    $sel->bindParam(3, $artist_tag,     PDO::PARAM_STR, 128);
    $sel->bindParam(4, $another_tag,    PDO::PARAM_STR, 128);
    $sel->bindParam(5, $img_status,     PDO::PARAM_STR, 128);
    $sel->bindParam(6, $source,         PDO::PARAM_STR, 128);

    $sel->execute([$main_tag, $second_tag,$artist_tag,$another_tag,$img_status,$source]);

    $another_tag_array = explode(",", $another_tag);

    //處理another_tag 後 傳上資料庫`tag_data`
    $sel =  "SELECT * FROM `tag_data`  WHERE `creat_user_id`='$user_id'";
    $sdv = querytagids($sel);

    foreach ($another_tag_array as $k => $v) {
        if (isset($sdv)) {
            foreach ($sdv as $_k => $_v) {
                //如果有空白NULL 或是 當下全tag = 當下輸入tag
                if ($_v['tag_name'] == null || $_v['tag_name'] == $v) {
                    $id = $_v['id'];
                    // echo "更新ID第" . $id . "目前的tag是" . $v . "<br>";

                    $_sel = "UPDATE `tag_data` SET `tag_name`='$v' WHERE `id`='$id'";
                    $link->query($_sel);
                    $ss = "true";
                    break;
                } else {
                    $ss = "false";
                }
            }
            if ($ss == "false") {
                $_sel = "INSERT INTO `tag_data`(`tag_name`,`creat_user_id`,`type`) VALUES ('$v','$user_id','')";
                $link->query($_sel);
            }
        }else{
            $_sel = "INSERT INTO `tag_data`(`tag_name`,`creat_user_id`,`type`) VALUES ('$v','$user_id','')";
                $link->query($_sel);
        }
    }


    echo '<script>alert("修改成功");</script>';
    header("Location: indexTWO.php?img_id=$img_id");
    ob_end_flush();
endif;
