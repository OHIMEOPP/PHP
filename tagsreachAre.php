<?php
require_once 'function.php';
?>
<div class="imgAre_out">
    <div class="imgAre">
        <div>
            <form method="post" id="from_s">
                <select name="select_sort" id="select_sort">
                    <option><?php if (isset($_POST['select_sort'])) echo "排序:" . $_POST['select_sort'];
                            else echo "排序:" . "ID" ?></option>
                    <option value="ID">ID</option>
                    <option value="圖片名稱">圖片名稱</option>
                    <option value="上傳日期">上傳日期</option>
                    <option value="人物">人物</option>
                    <option value="團體">團體</option>
                    <option value="作者">作者</option>
                </select>
            </form>
            <a href="#">圖片名稱</a>

            <div id="timeblock">
            </div>
        </div>
        <?php
        $inputtag = $_GET['tag'];
        $sel = "SELECT * FROM `img_data`  WHERE `creat_user_id` = {$user_id}";
        $user = queryimgids($sel);
        if(isset(explode(",",$inputtag)[0])){
            echo explode(",",$inputtag)[0];
        }

        if (isset($inputtag)) {
            //遍歷圖片資訊
            foreach ($user as $row1 => $v) {
                //取圖片各種tag
                $anotherTag =  explode(",", $user[$row1]['anotherTag']);

                array_push($anotherTag, $user[$row1]['mainTag']);
                array_push($anotherTag, $user[$row1]['secondaryTag']);
                array_push($anotherTag, $user[$row1]['ArtistTag']);
                //買次檢查當下圖片有沒有被查詢的tag 如果有 ，資訊填入陣列
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
        // print_r($anotherTag);
        echo "<div class='content'>";
        if (isset($tagsimg)) :
            imgdisplay($tagsimg, $inputtag);
        endif;
        echo "<div>";
        ?>

    </div>
</div>
<style>
    <?php require_once './css/imageAre.css' ?>
</style>