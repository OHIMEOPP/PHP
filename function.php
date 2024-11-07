<?php
// error_reporting(0);
// ini_set('display_errors', 0);
require_once 'db.php';
if (isset($_SESSION['user_id'][0]))
    $user_id = $_SESSION['user_id'][0];
else {
}
// echo $user_id;
function mysql_fix_string($pdo, $string)
{
    return $pdo->quote($string);
}
function select($sel)
{
    global $link;
    $data = $link->query($sel);
    return $data;
}
function _select($sel)
{
    $data = $sel->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}
function currentTime()
{
    date_default_timezone_set('Asia/Taipei');
    $current_time = date("Y-m-d H:i:s");
    return $current_time;
}
function ALLupcload($_file, $time, $c_user_id, $img_type)
{
    global $link;
    $file = $_file;
    $sel = "UPDATE `img_data` SET 
    `img_path`='$file', 
    `upload_date`='$time',
    `check_img_type`='$img_type' ,
    `creat_user_id`= {$c_user_id} 
    WHERE `creat_user_id`={$c_user_id} && `check_img_type`='$img_type'"; //GKDYbQta4AAi-44.jpg
    $result = $link->query($sel);
    header("Location:indexTWO.php?are=frontpage");
}
function queryAccount()
{
    $sel = "SELECT * FROM `user_account`";
    $data = select($sel);
    foreach ($data as $row1 => $v) {
        $user = array(
            'id' =>
                $v['id'],
            'name' =>
                $v['name']
        );
    }
    return $user;
}
function seleticon($img_type, $user_id)
{
    $sel = "SELECT * FROM `img_data` WHERE `check_img_type`='$img_type' && creat_user_id = {$user_id};";
    $data = select($sel);
    if (!is_null($data))
        foreach ($data as $row1) {
            $icon = array(
                'img_path' => array(
                    $row1['img_path']
                ),
                'check_img_type' => array(
                    $row1['check_img_type']
                )
            );
        }

    return $icon;
}
function queryimgids($sel)
{
    $data = select($sel);
    if (isset($data)) {
        while ($v = $data->fetch()) {
            $user[] = array(
                'id' => $v['id'],
                'img_path' => $v['img_path'],
                'check_img_type' => $v['check_img_type'],
                'mainTag' => $v['mainTag'],
                'creat_user_id' => $v['creat_user_id'],
                'secondaryTag' => $v['secondaryTag'],
                'ArtistTag' => $v['ArtistTag'],
                'anotherTag' => $v['anotherTag'],
                'upload_date' => $v['upload_date'],
                'ispublic' => $v['ispublic'],
                'source' => $v['source']
            );
        }
        return $user;
    }
}
function queryimgids2($sel)
{
    // $data = _select($sel);
    if (isset($data)) {
        while ($v = $data->fetch(PDO::FETCH_ASSOC)) {
            $user[] = array(
                'id' => $v['id'],
                'img_path' => $v['img_path'],
                'check_img_type' => $v['check_img_type'],
                'mainTag' => $v['mainTag'],
                'creat_user_id' => $v['creat_user_id'],
                'secondaryTag' => $v['secondaryTag'],
                'ArtistTag' => $v['ArtistTag'],
                'anotherTag' => $v['anotherTag'],
                'upload_date' => $v['upload_date'],
                'ispublic' => $v['ispublic'],
                'source' => $v['source']
            );
        }
        return $user;
    }
}
function querytagids($sel)
{
    $data = select($sel);
    if (!empty($data)) {
        while ($v = $data->fetch()) {
            $user[] = array(
                'tag_name' => $v['tag_name'],
                'type' => $v['type'],
                'id' => $v['id'],
            );
        }
        if (!empty($user))
            return $user;
    }
}
function current_tag($colname, $sel)
{
    $all_tag = querytagids($sel);
    if (isset($all_tag)) {
        $all_tag_array = [];
        foreach ($all_tag as $_k => $_v) {
            if (!in_array($_v[$colname], $all_tag_array)) {
                if ($_v[$colname] != null) {
                    array_push($all_tag_array, $_v[$colname]);
                }
            } else {
                // echo $_v['tag_name'];
            }
        }

        return $all_tag_array;
    }
}
function current_img($sel, $data_c)
{
    $all_img = queryimgids($sel);

    $all_img_array = [];
    foreach ($all_img as $_k => $_v) {
        if (!in_array($_v[$data_c], $all_img_array))
            if ($_v[$data_c] != null) {
                $explode_data = explode(',', $_v[$data_c]);
                foreach ($explode_data as $datas)
                    if (!in_array($datas, $all_img_array))
                        array_push($all_img_array, $datas);
            }
    }

    return $all_img_array;
}
function imgdisplay($user, $G_tag)
{
    $m_page = $_GET['page'] - 1;
    $p_page = $_GET['page'] + 1;
    $per = 16; //每頁顯示項目數量30
    $pages = ceil(count($user) / $per);
    $pages_end = count($user) % $per;
    if (!isset($_GET["page"])) { //假如$_GET["page"]未設置
        $page = 1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start = ($page - 1) * $per; //每一頁開始的資料序號
    $end = $page * $per - 1;

    //頁數等於最後一頁時
    if (isset($_GET['page']) && $_GET['page'] == $pages) {
        if ($pages_end == 0) {
            $pages_end == $per;
        } else {
            $end = $start + $pages_end - 1;
        }
    }

    // echo "<" . $pages_end . ">";
    echo "<div class='incontent'>";
    echo "<div class='contentblock' >";

    while ($start <= $end):

        //一般圖庫的情況
        if ($user[$start]['check_img_type'] == 'HTTP') {
            echo <<<_END
                        <div class="out"><div class="img_frame">
                        <a href='indexTWO.php?img_id=
                    _END;
            echo $user[$start]['id'] . " '>";
            echo "<img src='" . $user[$start]['img_path'] . " ' class='col-xs-12 col-sm-4 thumbnail' alt='...'>" . "</a>
                </div></div>";
        } else {
            echo <<<_END
                        <div class="out"><div class="img_frame">
                        <a href='indexTWO.php?img_id=
                    _END;
            echo $user[$start]['id'] . " '>";
            echo "<img src='" . "./uploadimg/" . $user[$start]['img_path'] . " ' class='col-xs-12 col-sm-4 thumbnail' alt='...'>" . "</a>
                </div></div>";
        }

        $start++;
    endwhile;
    echo "</div>";
    echo "</div>";
    if ($G_tag) {
        //tag=&page=1
        echo "<div class='pagebutton'><a href=?tag=" . $G_tag . "&&page=1>首頁</a> ";
        if ($page != 1) {
            echo "<a href=?tag=" . $G_tag . "&&page=$m_page>上一頁</a> ";
        }
        echo "第 ";
        for ($i = 1; $i <= $pages; $i++) {
            if ($page - 7 < $i && $i < $page + 7) {
                if ($i == $page) {
                    echo "<a href=?tag=" . $G_tag . "&&page=" . $i . "' style='color:white;'>" . $i . "</a> ";
                } else {
                    echo "<a href=?tag=" . $G_tag . "&&page=" . $i . ">" . $i . "</a> ";
                }
            }
        }
        if ($pages != $page) {
            echo "<a href=?tag=" . $G_tag . "&&page=$p_page>下一頁</a> ";
        }
        echo " 頁 <a href=?tag=" . $G_tag . "&&page=" . $pages . ">末頁</a><br /></div>";
        if ($pages < $_GET['page']) {
            echo "頁數比帶大";
        }
    } else {
        //分頁頁碼
        // echo '共 ' . $data_nums . ' 筆-在 ' . $page . ' 頁-共 ' . $pages . ' 頁';
        echo "<div class='pagebutton'><a href=?page=1>首頁</a> ";
        if ($page != 1) {
            echo "<a href=?page=$m_page>上一頁</a> ";
        }
        echo "第 ";
        for ($i = 1; $i <= $pages; $i++) {
            if ($page - 7 < $i && $i < $page + 7) {
                if ($i == $page) {
                    echo "<a href=?page=" . $i . "' style='color:white;'>" . $i . "</a> ";
                } else {
                    echo "<a href=?page=" . $i . ">" . $i . "</a> ";
                }
            }
        }
        if ($pages != $page) {
            echo "<a href=?page=$p_page>下一頁</a> ";
        }
        echo " 頁 <a href=?page=" . $pages . ">末頁</a><br /></div>";
    }
}
function selectsort($select_sort, $user_id, $inputtag, $sortDES)
{
    global $link;
    // $select_sort = $_POST['select_sort'];
    if (empty($inputtag)) {
        switch ($select_sort) {
            case "ID":
                $order = 'order by id';
                break;
            case "圖片名稱":
                $order = 'order by img_path';
                break;
            case "上傳日期":
                $order = 'order by upload_date';
                break;
            case "人物":
                $order = 'order by mainTag';
                break;
            case "團體":
                $order = 'order by secondaryTag';
                break;
            case "作者":
                $order = 'order by ArtistTag';
                break;
            case "人物未修改":
                $order = " && `mainTag` = '' order by upload_date ";
                break;
            case "團體未修改":
                $order = " && `secondaryTag` = '' order by upload_date ";
                break;
            case "作者未修改":
                $order = " && `ArtistTag` = '' order by upload_date ";
                break;
            case "其他標籤未修改":
                $order = " && `anothertag` = '' order by upload_date ";
                break;
        }
        $sel = "SELECT * FROM `img_data`   WHERE `creat_user_id` = {$user_id} && `check_img_type`!='icon' && `check_img_type`!='image' && `check_img_type`!='Wimage'  $order  $sortDES";
        if ($select_sort == "public")
            $sel = "SELECT * FROM `img_data`   WHERE `ispublic` = 'public' && `check_img_type`!='icon' && `check_img_type`!='image' && `check_img_type`!='Wimage' order by `upload_date` $sortDES  ";
    } else {
        switch ($select_sort) {
            case "ID":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id}  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%') order by `id`;";
                
                break;
            case "圖片名稱":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id}  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%') order by `img_path`  ";
                break;
            case "上傳日期":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id}  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%') order by `upload_date` desc";
                break;
            case "人物":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id}  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%') order by `mainTag` desc ";
                break;
            case "團體":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id}  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%')order by `secondaryTag`  ";
                break;
            case "作者":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id}  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%') order by `ArtistTag`  ";
                break;
            case "public":
                $sel = "SELECT * FROM `img_data` WHERE `ispublic` = 'public' && `check_img_type`!='icon' && `check_img_type`!='image' && `check_img_type`!='Wimage'  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%') order by `upload_date` desc  ";
                break;
            case "人物未修改":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id} && `mainTag` = ''  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%' )";
                break;
            case "團體未修改":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id} && `secondaryTag` = ''  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%' )";
                break;
            case "作者未修改":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id} && `ArtistTag` = ''  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%' )";
                break;
            case "其他標籤未修改":
                $sel = "SELECT * FROM `img_data` WHERE `creat_user_id` = {$user_id} && `anothertag` = ''  && (`anotherTag` 
                LIKE '%$inputtag%' || `mainTag` LIKE '%$inputtag%' || `secondaryTag` LIKE '%$inputtag%' || `ArtistTag` LIKE '%$inputtag%' )";
                break;
        }
    }
    return $sel;
}
function countmysql($tag, $tagType, $status)
{
    global $link;
    global $user_id;
    if ($status == 'single')
        $sql = "SELECT COUNT(*) FROM `img_data` WHERE `$tagType` LIKE :tag && `creat_user_id` = $user_id ";
    else {
        $sql = "SELECT COUNT(*) FROM `img_data` WHERE `$tagType` LIKE :tag &&  `ispublic` = 'public' ";
    }
    $stmt = $link->prepare($sql);
    $stmt->execute([
        ':tag' =>'%' . $tag . '%',
    ]);
    $cc = $stmt->fetchColumn();

    if (!empty($tag))
        return $cc;
}
function escape_mysql_string($array){
    global $link;

}