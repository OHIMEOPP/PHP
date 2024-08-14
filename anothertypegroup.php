<?php
require_once 'function.php';

function typechose($dbname, $s_tagtype, $user_id)
{
    switch ($dbname) {
        case 'tag_data':
            $sel = "SELECT * FROM `$dbname`  WHERE `creat_user_id` = {$user_id} && `type` = '$s_tagtype'";
            $tag = current_tag("tag_name", $sel);
            // $tag = json_encode($tag);
            return $tag;
            break;
        case 'img_data':
            $sel = "SELECT * FROM `img_data`  WHERE `creat_user_id` = {$user_id}";
            $imgs = queryimgids($sel);
            if (isset($imgs)) {
                $all_tag_array = [];
                foreach ($imgs as $_k => $_v) {
                    if (!in_array($_v[$s_tagtype], $all_tag_array)) {
                        if ($_v[$s_tagtype] != null) {
                            array_push($all_tag_array, $_v[$s_tagtype]);
                        }
                    }
                }
                // $all_tag_array = json_encode($all_tag_array);
                return $all_tag_array;
            }
            break;
    }
}
//frontpage的動態分類 需要的標籤 dynimictag()
if (isset($_POST['type']) && $_POST['type']) {
    $anotherTagtype = [];
    $anotherTagtype = typechose("tag_data", $_POST['type'], $user_id);

    if (is_array($anotherTagtype))
        foreach ($anotherTagtype as $k => $v)
            echo "<a  href='indexTWO.php?tag=" . $v . "&&page=1' draggable='true'>" . $v . "</a>";
}
//imagePage跟uploadare的動態分類 需要的標籤 _dynimictag()
else if (isset($_POST['_type']) && $_POST['_type']) {
    $anotherTagtype = [];
    if ($_POST['_type'] != "未分類") {
        $anotherTagtype = typechose("tag_data", $_POST['_type'], $user_id);
    } else {
        $anotherTagtype = typechose("tag_data", null, $user_id);
    }
    if (is_array($anotherTagtype)) {
        foreach ($anotherTagtype as $k => $v)
            echo "<a href='#' draggable='true'>" . $v . "</a>";
    }
} else if (isset($_POST['fw_type']) && $_POST['fw_type']) {
    $anotherTagtype = [];
    if ($_POST['fw_type'] == "未分類") {
        $anotherTagtype = typechose("tag_data", null, $user_id);
        if (is_array($anotherTagtype))
            foreach ($anotherTagtype as $k => $v)
                echo "<a class='tagblock' onclick='openedit(this.textContent)' href='#'>" . $v . "</a>";
    } else {
        $anotherTagtype = typechose("tag_data", $_POST['fw_type'], $user_id);
        if (is_array($anotherTagtype))
            foreach ($anotherTagtype as $k => $v)
                echo "<a class='tagblock' onclick='openedit(this.textContent)' href='#'>" . $v . "</a>";
    }
}
