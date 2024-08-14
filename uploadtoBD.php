<?php
require_once 'function.php';
$canAlert = false;
//檢查有沒有放檔案
if (isset($_FILES['uploadimg']['name']) && $_FILES['uploadimg']['name'] != '' || isset($_POST['uploadimg']) && $_POST['uploadimg'] != '') :
    //檢查檔案類型
    foreach ($_FILES['uploadimg']['name'] as $d => $f) {

        switch ($_FILES['uploadimg']['type'][$d]) {
            case 'image/jpeg':
                $ext = 'jpg';
                break;
            case 'image/gif':
                $ext = 'gif';
                break;
            case 'image/png':
                $ext = 'png';
                break;
            case 'image/tiff':
                $ext = 'tif';
                break;
            default:
                $ext = '';
                break;
                //檢查檔案類型
        }
        if ($ext || $_POST['uploadimg']) {
            if ($ext) {
                $uploadimg = $_FILES['uploadimg']['name'][$d];
                $type = 'normal';
            } else {
                $uploadimg =  $_POST['uploadimg'];
                $type = 'HTTP';
            }
            $main_tag = $_POST['main_tag'];
            $second_tag = $_POST['second_tag'];
            $artist_tag = $_POST['artist_tag'];
            $another_tag = $_POST['another_tag'];
            if (isset($_POST['img_status']))
                $img_status = $_POST['img_status'];
            else
                $img_status = 'public';
            $source = $_POST['source'];

            $time = currentTime();

            $name = $_FILES['uploadimg']['name'][$d];

            $check = '';

            $sel =  "SELECT * FROM `img_data`  WHERE `creat_user_id`='$user_id'";
            $all_img = queryimgids($sel);
            foreach ($all_img as $key => $value) {
                if ($all_img[$key]["img_path"] == $uploadimg) {
                    $check = true;
                    echo '<script>alert("上傳的圖片' . $uploadimg . '已存在 幫你擋掉喔~");</script>';
                    break;
                } elseif ($all_img[$key]["img_path"] != $uploadimg) {
                    $check = false;
                }
            }
            if ($check == false) :
                $sel = "INSERT INTO `img_data`(`img_path`, `upload_date`, `mainTag`, `secondaryTag`, `ArtistTag`, `anotherTag`, `creat_user_id`, `check_img_type`,`ispublic`,`source`) VALUES
            ('$uploadimg','$time','$main_tag','$second_tag','$artist_tag','$another_tag','$user_id','$type','$img_status','$source')";
                $link->query($sel);
                echo $source;
                $check = true;
                $another_tag_array = explode(",", $another_tag);

                //處理another_tag 後 傳上資料庫`tag_data`
                $sel =  "SELECT * FROM `tag_data`  WHERE `creat_user_id`='$user_id'";
                $sdv = querytagids($sel);
                //以逗號處理後的使用者輸入的標籤 來判別
                foreach ($another_tag_array as $k => $v) {
                    if (isset($sdv)) {
                        //如果沒有重複標籤
                        // if (!in_array($v, $all_tag)) {
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
                            $_sel = "INSERT INTO `tag_data`(`tag_name`,`creat_user_id`) VALUES ('$v','$user_id')";
                            $link->query($_sel);
                        }

                        // }
                    }
                    else{
                        $_sel = "INSERT INTO `tag_data`(`tag_name`,`creat_user_id`) VALUES ('$v','$user_id')";
                            $link->query($_sel);
                    }
                }
                $n = "./uploadimg/" .  $uploadimg;
                move_uploaded_file($_FILES['uploadimg']['tmp_name'][$d], $n);

                $canAlert = true;
            endif;
        } else echo "Is not an accepted image file";
    }
    $_FILES['uploadimg']['name'][$d] = null;
    $_POST['uploadimg'] = null;
    $_POST['main_tag'] = null;
    $_POST['second_tag'] = null;
    $_POST['artist_tag'] = null;
    $_POST['another_tag'] = null;
elseif (isset($_FILES['uploadimg']['name']) && $_FILES['uploadimg']['name'] == '') :
    echo '<script>alert("請上傳檔案或輸入網址");</script>';
endif;

if ($canAlert) {
    echo '<script>alert("上傳成功");</script>';
    $canAlert = false;
}
