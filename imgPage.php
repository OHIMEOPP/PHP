<?php
require_once 'function.php';
require_once 'classBD.php';
$img_id = $_GET['img_id'];

$singleimgdata = new singleIMGdb($_GET['img_id']);
$singleimgdata->query_img_db();

$img_path = $singleimgdata->img_path;
$upload_date = $singleimgdata->upload_date;
$check_img_type = $singleimgdata->check_img_type;
$mainTag = $singleimgdata->mainTag;
$secondaryTag = $singleimgdata->secondaryTag;
$ArtistTag = $singleimgdata->ArtistTag;
$anotherTag = $singleimgdata->anotherTag;
$creat_user_id = $singleimgdata->creat_user_id;
$imgstatus = $singleimgdata->ispublic;
$check_img_type = $singleimgdata->check_img_type;
$source = $singleimgdata->source;

$_mainTag = $mainTag;
$mainTag = explode(',', is_string($_mainTag) ? $_mainTag : "");

$_secondaryTag = $secondaryTag;
$secondaryTag = explode(',', is_string($_secondaryTag) ? $_secondaryTag : "");

$_ArtistTag = $ArtistTag;
$ArtistTag = explode(',', is_string($_ArtistTag) ? $_ArtistTag : "");

$_anotherTag = $anotherTag;
$anotherTag = explode(',', is_string($_anotherTag) ? $_anotherTag : "");

$_sel = "SELECT * FROM `img_data` WHERE `creat_user_id`='$user_id'";

$all_mainTag = json_encode(current_img($_sel, "mainTag"));

$all_secondaryTag = json_encode(current_img($_sel, "secondaryTag"));

$all_ArtistTag = json_encode(current_img($_sel, "ArtistTag"));

$_sel = "SELECT * FROM `tag_data` WHERE `creat_user_id`='$user_id'";

$jsonArray = json_encode(current_tag("tag_name", $_sel));


$tag_type = array("未分類");
if (!empty(current_tag("type", $_sel)))
    $tag_type = array_merge($tag_type, current_tag("type", $_sel));
$tag_type = json_encode($tag_type);

$url = "https://zh.moegirl.org.cn/";
?>
<style>
    <?php require_once './css/imgPage.css' ?>
    <?php require_once './css/switchBt.css' ?>
</style>
<div class="float_window float_set_window" id="float_set_window" style="display:none;">
    <img id="setpreview" src="<?php
    if ($check_img_type == 'HTTP') {
        echo $img_path;
    } else
        echo "./uploadimg/" . $img_path;

    ?>" class="col-xs-12 col-sm-4 thumbnail" alt="...">
    <form method="post" id="set_tag_m" action="settag.php">
        <input type="text" name="imgid" style="display:none" value="<?php echo $img_id ?>">
        <div style="display: flex;">
            <p>圖片狀態(status)</p>
            <label class="switch">
                <input type="checkbox" id="toggleSwitch" name="img_status" <?php if ($imgstatus == "私人")
                    echo "checked";
                else {
                } ?>>
                <span class="slider round"></span>
            </label>
            <p id="status">狀態: <?php echo $imgstatus ?></p>
        </div>
        <div>人物<input type="text" name="set_maintag" id="set_maintag" value="<?php echo $_mainTag ?>"></div>
        <div>團體<input type="text" name="set_secondarytag" id="set_secondarytag" value="<?php echo $_secondaryTag ?>">
        </div>
        <div>作者<input type="text" name="set_artisttag" id="set_artisttag" value="<?php echo $_ArtistTag ?>"></div>
        <div>圖源<input type="text" name="set_source" id="set_source" value="<?php echo $source ?>"></div>
        <div>其他<textarea type="text" name="set_anothertag" id="set_anothertag"
                value=""><?php echo $_anotherTag ?></textarea></div>
        <div class="relate_tags">
            <a href="#" onclick="closeare('c_main','set_maintag')" id="c_main" data-toggle="collapse"
                data-target="#demo">人物</a>
            <a href="#" onclick="closeare('c_secondary','set_secondarytag')" id="c_secondary" data-toggle="collapse"
                data-target="#demo">團體</a>
            <a href="#" onclick="closeare('c_artist','set_artisttag')" id="c_artist" data-toggle="collapse"
                data-target="#demo">作者</a>
            <a href="#" onclick="closeare('c_another','set_anothertag')" id="c_another" data-toggle="collapse"
                data-target="#demo">其他</a>
            <!-- <a onclick="closeare()" id="c_secondary" data-toggle="collapse" data-target="#demo">團體標籤</a> -->
        </div>

        <button type="submit">確定</button>
    </form>

    <button onclick="setimg_formation()">取消</button>
    <div id="demo" class="collapse">
    </div>
</div>

<div class="all_page">

    <div class="whole_img_tag">

        <h4> 人物</h4>
        <div>
        <?php foreach ($mainTag as $v): ?>
            <div>
            <li>
                <a href="indexTWO.php?tag=<?php echo $v ?>&&page=1">
                    <?php
                    echo $v;
                    ?>
                </a>
                <a href="#">
                    <?php
                    echo countmysql($v, 'mainTag', 'single');
                    ?>
                </a>
                <a href="#">
                    <?php
                    echo countmysql($v, 'mainTag', 'group');
                    ?>
                </a>
                <?php if ($v): ?><a href="#"
                        onclick="window.open('<?php echo $url . $v ?>','_blank')">🔍</a><?php endif; ?>

            </li>
            </div>
            <?php endforeach; ?>
        </div>
        <hr align="left">
        <h4>團體</h4>
        <div>
        <?php foreach ($secondaryTag as $v): ?>
            <div>
            <li>
                <a href="indexTWO.php?tag=<?php echo $v ?>&&page=1">
                    <?php
                    echo $v;
                    ?>
                </a>
                <a href="#">
                    <?php
                    echo countmysql($v, 'secondaryTag', 'single');
                    ?>
                </a>
                <a href="#">
                    <?php
                    echo countmysql($v, 'secondaryTag', 'group');
                    ?>
                </a>
            </li>
            </div>
            <?php endforeach; ?>
        </div>
        <hr align="left">
        <h4>作者</h4>
        <div>
        <?php foreach ($ArtistTag as $v): ?>
            <div>
            <li>
                <a href="indexTWO.php?tag=<?php echo $v ?>&&page=1">
                    <?php
                    echo $v;
                    ?>
                </a>
                <a href="#">
                    <?php
                    echo countmysql($v, 'ArtistTag', 'single');
                    ?>
                </a>
                <a href="#">
                    <?php
                    echo countmysql($v, 'ArtistTag', 'group');
                    ?>
                </a>
            </li>
            </div>
            <?php endforeach; ?>
        </div>
        <hr align="left">
        <h4>其他</h4>
        <div>
            <?php foreach ($anotherTag as $v): ?>
                <div>
                    <li>
                        <a href="indexTWO.php?tag=<?php echo $v ?>&&page=1">
                            <?php echo $v; ?>
                        </a>
                        <a href="#">
                            <?php
                            echo countmysql($v,'anotherTag', 'single');
                            ?>
                        </a>
                        <a href="#">
                            <?php
                            echo countmysql($v,'anotherTag', 'group');
                            ?>
                        </a>
                    </li>
                </div>
            <?php endforeach; ?>

        </div>
        <hr align="left">
        <h4>資訊</h4>
        <div class="_tag_infomation">
            <div class="img_path">
                圖片位址/名稱:
                <a href=<?php if ($check_img_type == 'HTTP') {
                    echo $img_path;
                } else {
                    echo "./uploadimg/" . $img_path;
                }
                ?>> <?php echo $img_path; ?></a>
            </div>
            <div class="update">上傳日期:<?php echo $upload_date ?></div>

            <div class="update">檔案大小:<?php if ($check_img_type == 'HTTP')
                echo "圖片位址圖，無檔案大小";
            else
                echo filesize("./uploadimg/$img_path"); ?></div>
            <div class="img_path">圖源:
                <a href='<?php echo $source ?>'><?php echo $source ?></a>
            </div>

        </div>
        <hr align="left">
        <h4>圖片狀態</h4>
        <div>
            <div>
                <li>
                    <?php echo $imgstatus ?>
                </li>
            </div>
        </div>
        <div class="set_row">

            <?php
            if ($check_img_type != 'image' && $check_img_type != 'Wimage' && $check_img_type != 'icon' && $creat_user_id == $user_id) {
                echo
                    "<div class=delete_img_bt>
                        <button id='setimgbt' onclick='setimg_formation()'>編輯</button>
                    </div>";
                echo
                    "<div class=delete_img_bt>
                        <button onclick='deleteIMG()'>刪除</button>
                    </div>";
            } else if ($creat_user_id != $user_id) {
                echo
                    "<div class=delete_img_bt>
                        此為使用者公開圖像，無法編輯
                    </div>";
            } else {
                echo
                    "<div class=delete_img_bt>
                        此為首頁UI圖像，無法編輯
                    </div>";
            }
            ?>
        </div>
    </div>
    <div>
        <a id="downLoad" style="color: black" onclick="downLoad()">DownLoad</a>
    </div>
    <div class="display_img">
        <div class="whole_img">
            <img onclick="enlargeDisplay()" id="whole_img" src="<?php
            if ($check_img_type == 'HTTP') {
                echo $img_path;
            } else
                echo "./uploadimg/" . $img_path;

            ?>" class="col-xs-12 col-sm-4 thumbnail" alt="...">
        </div>
    </div>
</div>

<script src="tetx.js"></script>
<script>
    function downLoad() {
        const imgPath = "<?php echo $img_path ?>";
        const link = document.createElement("a");
        link.href = document.getElementById("whole_img").src;
        link.download = imgPath;
        link.click();

    }
    function deleteIMG() {
        if (confirm("要刪除此圖片嗎")) {
            window.location.href = "setimgstatus.php?img_id=<?php echo $img_id ?>";
        }

    }

    function setimg_formation(e) {
        if (e) {
            var set_tag_m = document.getElementById(e);
        } else
            var set_tag_m = document.getElementById("float_set_window");
        let isScrollDisabled = false;
        if (set_tag_m.style.display == "none") {
            set_tag_m.style.display = "flex";
            window.scrollBy(0, -10000);
            isScrollDisabled = !isScrollDisabled;
            document.body.classList.toggle('no-scroll', isScrollDisabled);

        } else {
            set_tag_m.style.display = "none";
            isScrollDisabled = false;
            document.body.classList.toggle('no-scroll', isScrollDisabled);
        }
    }

    function closeare(e, I_id) {
        //>團體 --人物
        var c_div = document.getElementById("demo");
        var cv = I_id;
        const searchInput = document.getElementById(I_id);
        const suggestionsDiv = document.getElementById('demo');
        var suggestions = [];
        // 监听输入事件
        searchInput.addEventListener('input', function () {
            var aa = this.value.trim(); // 获取输入的文本，并去除首尾空格
            var inputValue = this.value;
            if (inputValue.includes(',')) {
                // 將字串分割成陣列
                var arrayAfterComma = inputValue.split(',');
                // 取得逗號後的字串並加入陣列
                var lastPartOfString = arrayAfterComma[arrayAfterComma.length - 1];
                var aa = lastPartOfString; // 這將會印出逗號後的字串
            }

            // suggestions = suggestions.filter(function (suggestion) {
            //     return suggestion.includes(aa); // 过滤包含输入文本的提示

            // });
            const filteredSuggestions = suggestions.filter(function (suggestion) {
                return suggestion.includes(aa); // 过滤包含输入文本的提示
            });
            sreach_drop(c_div, filteredSuggestions, searchInput, suggestionsDiv); // 显示过滤后的提示
            // console.log(filteredSuggestions);
        });




        if (c_div.className == "collapse") {
            switch (e) {
                case "c_main":
                    suggestions = <?php echo $all_mainTag; ?>;
                    sreach_drop(c_div, suggestions, searchInput, suggestionsDiv);
                    break;
                case "c_secondary":
                    suggestions = <?php echo $all_secondaryTag; ?>;
                    sreach_drop(c_div, suggestions, searchInput, suggestionsDiv);
                    break;
                case "c_artist":
                    suggestions = <?php echo $all_ArtistTag; ?>;
                    sreach_drop(c_div, suggestions, searchInput, suggestionsDiv);
                    break;
                case "c_another":
                    suggestions = <?php echo $jsonArray ?>;
                    tag_type = <?php echo $tag_type; ?>;
                    // sreach_drop(c_div,suggestions,searchInput,suggestionsDiv);
                    _dynamictagtype(searchInput, tag_type);
                    break;
            }
        }

    }

    function enlargeDisplay() {
        const whole_img = document.getElementById("whole_img");
        const whole_img_enlarge = document.getElementById("whole_img_enlarge");

        if (whole_img) {
            whole_img.style.maxHeight = "none";
            whole_img.style.maxWidth = "none";

            whole_img.id = "whole_img_enlarge";
        } else {
            whole_img_enlarge.style.maxHeight = "120vh";
            whole_img_enlarge.style.maxWidth = "100%";

            whole_img_enlarge.id = "whole_img";
        }


    }

    function chosesreach_fw() {
        setimg_formation('sreachTag');
    }
    document.getElementById('toggleSwitch').addEventListener('change', function () {
        const status = document.getElementById('status');
        if (this.checked) {
            status.textContent = '狀態: 私人';
            this.value = 'private';
        } else {
            status.textContent = '狀態: 公開';
            this.value = 'public';
        }
    });
</script>