<style>
    <?php require_once './css/uploadare.css' ?>
</style>
<?php
require_once 'uploadtoBD.php';
$title = '上傳區';
$_sel = "SELECT * FROM `img_data` WHERE `creat_user_id`='$user_id'";
$all_mainTag = current_img($_sel, "mainTag");
$all_mainTag = json_encode($all_mainTag);

$all_secondaryTag = current_img($_sel, "secondaryTag");
$all_secondaryTag = json_encode($all_secondaryTag);

$all_ArtistTag = current_img($_sel, "ArtistTag");
$all_ArtistTag = json_encode($all_ArtistTag);

$_sel = "SELECT * FROM `tag_data` WHERE `creat_user_id`='$user_id'";
$all_tag = current_tag('tag_name', $_sel);
$jsonArray = json_encode($all_tag);

$_sel = "SELECT * FROM `tag_data` WHERE `creat_user_id`='$user_id'";
$tag_type = array("未分類");
if (!empty(current_tag("type", $_sel)))
    $tag_type = array_merge($tag_type, current_tag("type", $_sel));
$tag_type = json_encode($tag_type);

?>
<style>
    <?php require_once './css/switchBt.css' ?>
</style>
<div class="upload_are">
    <div class="upload_form">
        <div class="img_are">
            <div class="_img">
                <img src="" id="img_are_IMG">
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="up_tag">
                    <div class="img_are_input">
                        <input id="cl" onclick="chagebutton()" placeholder="" style=display:none>
                        <label for="cl">🔄</label>
                        <input type="file" id="img_are_input" accept="image/*" name="uploadimg[]" multiple>
                        <input type="text" id="img_are_input_text" name="uploadimg" style="display:none"
                            placeholder="輸入圖片位址(非網址)">
                    </div>
                    <div class="input_tag">
                        <div class="main_tag">
                            <p>人物(main Tag)</p>
                            <input type="text" name="main_tag" autocomplete="off" id="main_tag">
                        </div>
                        <div class="second_tag">
                            <p>團體(second Tag)</p>
                            <input type="text" name="second_tag" autocomplete="off" id="second_tag">
                        </div>
                        <div class="artist_tag">
                            <p>作者(artist Tag)</p>
                            <input type="text" name="artist_tag" autocomplete="off" id="artist_tag">
                        </div>
                    </div>
                    <p>圖源(source)</p>
                    <div class="source_zone">
                        <div style="display:flex;">
                            <textarea id="source_textare" type="text" name="source" placeholder="source"
                                autocomplete="off"></textarea>
                        </div>
                        <div style="display: flex;">
                            <p>圖片狀態(status)</p>
                            <label class="switch">
                                <input type="checkbox" id="toggleSwitch" name="img_status">
                                <span class="slider round"></span>
                            </label>
                            <p id="status">狀態: 公開</p>
                        </div>
                        <p>其他標籤(another Tag)</p>
                        <div class="another_tag">
                            <div style="display:flex;">
                                <textarea contenteditable="true" dropzone="copy" id="textare" type="text"
                                    name="another_tag" placeholder="金髮,黑絲,藍瞳,.....(以豆號分隔)"
                                    autocomplete="off"></textarea>
                                <div id="demo" class="collapse">
                                </div>
                            </div>
                            <div class="relate_tags">
                                <a href="#" onclick="closeare('c_main','main_tag')" id="c_main" data-toggle="collapse"
                                    data-target="#demo">人物</a>
                                <a href="#" onclick="closeare('c_secondary','second_tag')" id="c_secondary"
                                    data-toggle="collapse" data-target="#demo">團體</a>
                                <a href="#" onclick="closeare('c_artist','artist_tag')" id="c_artist"
                                    data-toggle="collapse" data-target="#demo">作者</a>
                                <a href="#" onclick="closeare('c_another','textare')" id="c_another"
                                    data-toggle="collapse" data-target="#demo">其他</a>
                                <!-- <a onclick="closeare()" id="c_secondary" data-toggle="collapse" data-target="#demo">團體標籤</a> -->
                            </div>
                        </div>
                        <button type="submit" onclick="uoload_willingness()">上傳</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- <script src="OSC.js"></script> -->
<script src="myScript.js"></script>
<script>
    uploads();

    function uploads() {
        //顯示上傳圖片
        var filename = document.getElementById("img_are_input");
        var img = document.getElementById("img_are_IMG");
        // var img1 = document.getElementById("img");
        filename.onchange = function () {
            // img.style.backgroundImage = "url('" + URL.createObjectURL(this.files[0])
            // img.src = URL.createObjectURL(this.files[0]);
            img.src = URL.createObjectURL(this.files[0]);
            return;
        }
    }

    function chagebutton() {
        var inputElement = document.getElementById("img_are_input");
        var textElement = document.getElementById("img_are_input_text");
        if (inputElement.style.display === "none") {
            inputElement.style.display = "block";
            textElement.value = '';
            textElement.style.display = "none";
        } else {
            inputElement.style.display = "none";
            inputElement.value = '';
            inputElement.dis
            textElement.style.display = "block";
        }

        function uoload_willingness() {
            if (confirm("要上船嗎?")) {
                alert("dd");
            }
        }

    }

    function closeare(e, I_id) {
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
            console.log("filteredSuggestions");
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



    function O(i) {
        return typeof i == 'object' ? i : document.getElementById(i)
    }

    function S(i) {
        return O(i).style
    }

    function C(i) {
        return document.getElementsByClassName(i)
    }
    O(img_are_IMG).onclick = function () {
        // this.src = './uploadimg/sumi.jpg'
    }
    // O('img_are_IMG').onmouseout = function() {
    //     this.src = 'https://pbs.twimg.com/media/GL-pbmVa0AAF6X-?format=jpg&name=large'
    // }
    {
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
        document.getElementById('source_textare').addEventListener('input', function () {
            if (document.getElementById('source_textare').value.trim() != '') {
                console.log('空')
            }
        });

        console.log(isUrl('https://www.w3schools.com/html/html_form_input_types.asp')); // true
        console.log(isUrl('www.baidu.com')); // false

    }
</script>