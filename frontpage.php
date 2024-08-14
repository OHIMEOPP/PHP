<?php

// $icon =  seleticon('icon');
$wimg =  seleticon('Wimage', $user_id);
$sel = "SELECT * FROM `img_data`  WHERE `creat_user_id` = {$user_id}";
$imgs = queryimgids($sel);
if ($imgs) {
    foreach ($imgs as $key => $value) {
        $imgamount = $key + 1;
    }
} else {
    $imgamount = "還沒有圖片喔";
}

$sel = "SELECT * FROM `tag_data`  WHERE `creat_user_id` = {$user_id}";
$tags = current_tag("tag_name", $sel);
if ($tags) {
    foreach ($tags as $key => $value) {
        // echo $value . "<br>";
        $tagamount = $key + 1;
    }
} else {
    $tagamount = "還沒有標籤喔";
}
$sel = "SELECT * FROM `tag_data`  WHERE `creat_user_id` = {$user_id}";
$tag_type = array("未分類");
if (!empty(current_tag("type", $sel))) {
    $O_tag =  current_tag("type", $sel);
    $_tag_type = $tag_type = array_merge($tag_type, $O_tag);
    $tag_type = json_encode($tag_type);
    $_tag_type = $O_tag;
    $_tag_type = json_encode($_tag_type);
}else{
    $tag_type = json_encode($tag_type);
    $_tag_type = json_encode([]);
}

function typechose($dbname, $s_tagtype, $user_id)
{
    switch ($dbname) {
        case 'tag_data':
            $sel = "SELECT * FROM `$dbname`  WHERE `creat_user_id` = {$user_id} && `type` = '$s_tagtype'";
            $tag = current_tag("tag_name", $sel);
            
            if (!empty($tag)) {
                $tag = json_encode($tag);
                return $tag;
            }
            else{
                $tag = array('還沒有標籤喔');
                $tag = json_encode($tag);
                return $tag;
            }
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
                if (!empty($all_tag_array)) {
                    $all_tag_array = json_encode($all_tag_array);
                    return $all_tag_array;
                }
                else{
                    $all_tag_array = array('還沒有標籤喔');
                    $all_tag_array = json_encode($all_tag_array);
                    return $all_tag_array;
                }
            }
            break;
    }
}

?>
<div class="float_window" id="plus_tag_div" style="display: none;">
    <!-- <div> -->
    <div class="pl_tag_w">

        <span onclick="plustaggroup()">✕</span>
        <!-- 切換標籤編輯選項表頭 -->
        <h3 id="f_w_head">
            <a href="#" data-content='add_new_tag'>新增標籤</a><a href="#" data-content='revise_tag'>修改標籤</a><a href="#" onclick='fw_tagchange(".tag_type_checktag_chose_tag",<?php echo typechose("tag_data", null, $user_id) ?>) ' data-content='tag_type'>標籤分類</a>
        </h3>
        <!-- 新增標籤區域 是預設顯示 -->
        <div class="add_new_tag" style="display: block;">
            <form id="add_new_tag_form" method="post" action="frontpagetagedit.php">
                <div id="f_w__input">

                    <h4>
                        <p>標籤名稱</p>
                    </h4>
                    <input id="f_w_p_T_I" type="text" placeholder="輸入您的標籤名稱">
                    <h4>
                        <p>新增分類</p>
                    </h4>
                    <input id="f_w_p_TG_I" type="text" placeholder="要新增分類嗎?">
                </div>
                <h4>
                    <p>選擇現有分類</p>
                </h4>

                <h3>
                    <!-- <p></p> -->
                </h3>
                <div class="checktag">
                    <a class="tagblock">
                    </a>

                </div>
            </form>
        </div>
        <!-- 修改標籤區域 顯示關閉 -->
        <div class="revise_tag" style="display:none">
            <div id="revise_tag_checktag_after" style="display: block">

                <h4>
                    <p>選擇修改標籤</p>
                </h4>
                <div class="revise_tag_checktag">

                </div>
            </div>
            <form id="revise_tag_form" method="post" action="frontpagetagedit.php" style="display:none">
                <h4>
                    <a href="#" onclick="openedit()"><- </a>
                </h4>
                <div id="f_w__input">

                    <h4>
                        <p>標籤名稱</p>
                    </h4>
                    <input id="f_w_fixed_T_I" type="text" placeholder="輸入您的標籤名稱" name="edit_tagname">
                    <input id="backvalue" type="" name="backvalue" style="display: none;">
                    <input id="disbackvalue" type="button" disabled>
                    <h4>
                        <p>新增分類</p>
                    </h4>
                    <input id="f_w_fixed_TG_I" type="text" placeholder="要新增分類嗎?" name="add_tagtype">
                </div>
                <h4>
                    <p>選擇現有分類</p>
                </h4>
                <h3>
                    <!-- <p></p> -->
                </h3>
                <div class="revise_tag_type_checktag">
                </div>
            </form>
        </div>
        <!-- 分類標籤區域 顯示關閉 -->
        <div class="tag_type" style="display:none">
            <form id="tag_type_form" method="post" action="frontpagetagedit.php">
                <h4>
                    <p>選擇分類</p>
                </h4>

                <div class="tag_type_checktag">
                </div>
                <h4>
                    <p>未分類標籤</p>
                </h4>
                <div class="tag_type_checktag_chose_tag">
                </div>

            </form>
        </div>
        <!-- 表單送出或取消 -->
        <div class="select_col">
            <a onclick="submit_fl_table('submit')" href="#">確定</a>
            <a onclick="fw_cancel_close()" href="#">取消</a>
        </div>
    </div>

    <!-- </div> -->
</div>
</div>
<div class="mainframe">
    <!--div為容器 class名稱為waring-->
    <div class="warning_out">
        <div class="warning" style='background-image :url("<?php echo "./uploadimg/" . $wimg['img_path'][0]; ?>") ;'>
            <!-- 映出所有圖片 -->
            <?php foreach ($imgLight as $key) : ?>
                <!-- <a href=<?php echo $myTwitter ?>><img src="<?php echo $key; ?>"></a> -->
            <?php endforeach; ?>

            <!-- <p id="mytext">我的跑馬燈\ w o w / <br> <?php echo date("Y/m/d H:i:s"); ?></p> -->
            <div class="warningIMG">

                <div class="readwarningBG" id="wBG">
                    <form class="wfrom" id="wform" method="post" enctype="multipart/form-data" action="indexTWO.php">

                        <label for="wimg">
                            <!-- 上傳圖片按鈕的圖片 -->
                            <img src="imageUI/uploadIMG.png" width="25" height="25">
                        </label>
                        <input type="file" id="wimg" accept="image/*" name="Wimage" style="display:none ">
                        <!-- <img id="wimg" src="imag/uploadIMG.png"  width="80" height="80"> -->
                    </form>
                </div>

            </div>
            <div class="warningicon_out">
                <div class="warningicon">
                    <form class="icon_from" id="icon_from" method="post" enctype="multipart/form-data" action="indexTWO.php">
                        <input type="file" id="icon_input" accept="image/*" name="icon" style="display:none">
                        <!-- <img id="wimg" src="imag/uploadIMG.png"  width="80" height="80"> -->
                        <label for="icon_input">
                            <!-- 上傳圖片按鈕的圖片 -->
                            <img src="<?php echo "./uploadimg/" . $icon['img_path'][0]; ?>">
                        </label>
                    </form>
                    <!-- <img src="./uploadimg/oringle6.jpg"> -->
                </div>
            </div>
        </div>
    </div>


    <div class="warning_out">
        <div class="front-index">
            <div class="front">
                <div class="front_right">
                    <div class="co1-1" id="distag">
                        <div class="taghead">
                            <h3>我的標籤</h3>
                            <!-- <div id="changeI"><a href="#" onclick="changeinput_tag()" style='background-color:unset'>點我增加標籤</a></div>
                            <div class="changeB" id="changeB" style="display:none">
                                <input type="text" id="plustag">
                                <input onclick="changeinput_tag()" type="button" id="plusbt"> -->

                            <!-- </div> -->
                        </div>
                        <?php
                        echo "<a href='#'  id='p' onclick='plustaggroup()' style='background-color:'>+</a>";
                        echo "<a href='#'  id='m' onclick='minustaggroup()' style='background-color:' >-</a>";
                        echo "<p id='taggroupline'><a onclick='tagchange(" . typechose("tag_data", null, $user_id) . ") '>未分類</a>";
                        echo "<a onclick='tagchange(" . typechose("img_data", "mainTag", $user_id) . ")' >人物</a>";
                        echo "<a  onclick='tagchange(" . typechose("img_data", "secondaryTag", $user_id) . ")'  >團體</a>";
                        echo "<a  onclick='tagchange(" . typechose("img_data", "ArtistTag", $user_id) . ")'  >作者</a></p>";
                        echo "<p><a id='expand' href='#' onclick='distag()' >查看全部</a></p>";
                        echo "";
                        ?>
                        <div id='tablecontent'>
                        </div>
                    </div>
                    <div class="co1-1">
                        <span class="">label asd</span>
                    </div>
                    <div class="co1-1">
                        <span class="">label asd</span>
                    </div>
                </div>
                <div class="front_left">
                    <div class="co1-2">
                        <h3 class="">內容</h3>
                        <p class="">擁有的圖片數量:<?php echo $imgamount ?></p>
                        <p class="">擁有的標籤數量:<?php echo $tagamount ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="upload_BG_ImgAre">

        <!-- 上傳圖片的地方 -->
        <form class="from" id="form" method="post" enctype="multipart/form-data" action="indexTWO.php">
            <div class="upload_BG_ImgAre_inputButton">
                <!-- 選擇上傳圖片 -->
                <input type="file" id="upImg" accept="image/*" name="image" style="display:none">

                <label for="upImg">
                    <!-- 上傳圖片按鈕的圖片 -->
                    <img src="imageUI/uploadIMG.png" width="100" height="100">
                </label>
                <!-- <input type="submit" value="確定"> -->
            </div>
        </form>

    </div>
</div>
<style>
    <?php require_once './css/frontpage.css' ?>#distag.open {
        height: 500px;
    }
</style>

<script>
    const f_w_head = document.querySelectorAll('#f_w_head a');
    var contentDiv = document.getElementById("tablecontent");


    const tag_type = <?php echo $tag_type ?>;
    const o_tag_type = <?php echo $_tag_type ?>;
    const tagLinks = document.querySelectorAll('#tablecontent a');
    displayanime(tagLinks);
    dynamictagtype();

    autoSubmit();

    function autoSubmit() {
        document.getElementById('upImg').addEventListener('change', function() {
            document.getElementById('form').submit();
        });
        document.getElementById('wimg').addEventListener('change', function() {
            document.getElementById('wform').submit();
        });
        document.getElementById('icon_input').addEventListener('change', function() {
            document.getElementById('icon_from').submit();
        });
        return;
    }

    function distag() {
        const expand = document.getElementById('expand');
        const tagDiv = document.getElementById('distag');
        tagDiv.classList.toggle('open');

    }

    function changeinput_tag() {
        var inputElement = document.getElementById("changeB");
        var textElement = document.getElementById("changeI");
        if (inputElement.style.display === "none") {
            inputElement.style.display = "flex";
            textElement.style.display = "none";
        } else {
            inputElement.style.display = "none";
            textElement.style.display = "flex";
        }
    }

    function dynamictagtype() {

        const taggroupline = document.getElementById("taggroupline");
        if (o_tag_type) {
            o_tag_type.forEach(function(type) {
                const a = document.createElement("a");
                a.href = "#";
                //當按下a時傳送post
                a.onclick = function() {

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "anothertypegroup.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            contentDiv.innerHTML = this.responseText;

                            const tagLinks = document.querySelectorAll('#tablecontent a');

                            displayanime(tagLinks);
                        }
                    };
                    xhr.send("type=" + type);
                };
                a.textContent = type;
                taggroupline.appendChild(a);
            });
        }
    }
    var navLinks = document.querySelectorAll('#taggroupline a');
    choseactive(navLinks);


    function choseactive(navLinks) {
        navLinks.forEach(link => {
            link.href = "#";
            link.addEventListener('click', (event) => {
                // 移除所有链接的active类
                navLinks.forEach(link => link.classList.remove('active'));

                // 添加active类到点击的链接
                event.currentTarget.classList.add('active');


            });
        });
    }
    // var navLinks = document.querySelectorAll('#taggroupline a');

    function plustaggroup() {
        const checktagDiv = document.querySelector(".checktag");

        creattagtypecheckbox(checktagDiv, "plus");


        const plus_tag_div = document.getElementById("plus_tag_div");
        let isScrollDisabled = false;
        if (plus_tag_div.style.display == "none") {
            plus_tag_div.style.display = "flex";
            window.scrollBy(0, -10000);
            const fw_navLinks = document.querySelectorAll('#f_w_head a');
            choseactive(fw_navLinks);

            isScrollDisabled = !isScrollDisabled;
            document.body.classList.toggle('no-scroll', isScrollDisabled);

        } else {
            plus_tag_div.style.display = "none";
            isScrollDisabled = false;
            document.body.classList.toggle('no-scroll', isScrollDisabled);

        }
    }

    function creattagtypecheckbox(checktagDiv, typecontent) {
        checktagDiv.textContent = "";
        navLinks.forEach(function(type) {
            const a = document.createElement("a");
            const input = document.createElement("input");
            const label = document.createElement("label");


            // label.htmlFor = type.textContent + typecontent;

            input.type = "radio";
            input.id = type.textContent + typecontent;
            input.name = "radio_tag_chose[]";
            input.value = type.textContent;
            label.textContent = type.textContent;
            label.appendChild(input);
            a.appendChild(label);

            a.className = "tagblock";
            checktagDiv.appendChild(a);
        });
    }
    switcheditare();

    function tagchange(tags) {
        contentDiv.textContent = '';
        if (tags) {
            tags.forEach(function(tag) {
                const a = document.createElement("a");
                a.draggable = 'true';
                a.textContent = tag;
                a.href = "indexTWO.php?tag=" + tag + "&&page=1";
                contentDiv.appendChild(a);

            });
        } else {
            contentDiv.textContent = '沒有標籤喔';
        }
        const tagLinks = document.querySelectorAll('#tablecontent a');
        displayanime(tagLinks);

    }

    function fw_tagchange(toDivClass, tags) {
        var contentDiv = document.querySelector(toDivClass);
        contentDiv.textContent = '';
        if (tags) {
            tags.forEach(function(tag) {
                const a = document.createElement("a");
                const input = document.createElement("input");
                const label = document.createElement("label");

                label.textContent = tag;
                label.htmlFor = tag;

                input.type = "checkbox";
                input.name = "check_tag_chose[]";
                input.value = tag;
                input.id = tag;

                a.className = "tagblock";
                a.appendChild(input);
                a.appendChild(label);
                contentDiv.appendChild(a);

            });
        } else {
            contentDiv.textContent = '沒有標籤喔';
        }

    }

    function displayanime(tagLinks) {
        tagLinks.forEach(function(tag, k) {
            setTimeout(() => {
                tag.classList.add("visible")
            }, k * 20)
        });
    }

    function switcheditare() {
        const add_new_tag = document.querySelector('.add_new_tag');
        const revise_tag = document.querySelector('.revise_tag');
        const _tag_type = document.querySelector('.tag_type');

        const revise_tag_type_checktag = document.querySelector(".revise_tag_type_checktag");
        const tag_type_checktag = document.querySelector(".tag_type_checktag");


        const tag_type = [];
        f_w_head.forEach(head => {
            head.addEventListener('click', (event) => {

                // 根据data-content属性切换内容
                const content = event.currentTarget.getAttribute('data-content');
                const select_col = document.querySelector(".select_col");
                switch (content) {
                    case "add_new_tag":
                        select_col.style.display = "block";

                        add_new_tag.style.display = 'block';
                        revise_tag.style.display = 'none';
                        _tag_type.style.display = 'none';
                        fw_cancel();
                        break;
                    case "revise_tag":

                        select_col.style.display = "none";
                        f_w_dynamictagtype(<?php echo $tag_type ?>);
                        add_new_tag.style.display = 'none';
                        revise_tag.style.display = 'block';
                        _tag_type.style.display = 'none';

                        creattagtypecheckbox(revise_tag_type_checktag, "2");
                        fw_cancel();
                        break;
                    case "tag_type":
                        select_col.style.display = "block";

                        add_new_tag.style.display = 'none';
                        revise_tag.style.display = 'none';
                        _tag_type.style.display = 'block';
                        creattagtypecheckbox(tag_type_checktag, "1");
                        fw_cancel();
                        break;
                }
            });
        });
    }

    function submit_fl_table(content) {
        var f_from = ""
        const add_new_tag = document.querySelector('.add_new_tag');
        const revise_tag = document.querySelector('.revise_tag');
        const fw_tag_type = document.querySelector('.tag_type');

        switch (content) {
            case "submit":
                // console.log(add_new_tag.style.display);
                if (add_new_tag.style.display == 'block') {
                    f_from = document.getElementById("add_new_tag_form");
                    if (confirm("要進行操作嗎?")) {
                        // f_from.submit();
                        console.log(f_from);
                    }
                } else if (revise_tag.style.display == 'block') {
                    const f_w_fixed_T_I = document.getElementById('f_w_fixed_T_I');
                    const f_w_fixed_TG_I = document.getElementById('f_w_fixed_TG_I');
                    const radiobox = document.querySelectorAll('input[name="radio_tag_chose[]"]');
                    var isinput = false;
                    var istypeinput = false;
                    var isradiobox = false;
                    f_from = document.getElementById("revise_tag_form");
                    if (f_w_fixed_T_I.value.trim() !== "") {
                        isinput = true;
                    }
                    if (f_w_fixed_TG_I.value.trim() !== "") {
                        istypeinput = true;
                    }
                    radiobox.forEach(box => {
                        if (box.checked) {
                            isradiobox = true;
                        }
                    });

                    if (confirm("要進行操作嗎?")) {
                        if (isinput == true && istypeinput == true && isradiobox == false || isinput == true && istypeinput == false && isradiobox == true) {
                            isinput = false;
                            istypeinput = false;
                            isradiobox = false;
                            f_from.submit();
                        } else {
                            alert("新增分類與選擇分類其中一項!");
                            isinput = false;
                            istypeinput = false;
                            isradiobox = false;
                            console.log(isinput);
                            console.log(istypeinput);
                            console.log(isradiobox);
                        }
                    }
                } else if (fw_tag_type.style.display == 'block') {
                    f_from = document.getElementById("tag_type_form");
                    const checkbox = document.querySelectorAll('input[name="check_tag_chose[]"]');
                    const radiobox = document.querySelectorAll('input[name="radio_tag_chose[]"]');
                    var ischeckbox = false;
                    var isradiobox = false;
                    checkbox.forEach(box => {
                        if (box.checked) {
                            ischeckbox = true;
                        }
                    });
                    radiobox.forEach(box => {
                        if (box.checked) {
                            isradiobox = true;
                        }
                    });
                    if (confirm("要進行操作嗎?")) {
                        if (ischeckbox == true && isradiobox == true) {
                            var ischeckbox = false;
                            var isradiobox = false;
                            f_from.submit();
                        } else {
                            var ischeckbox = false;
                            var isradiobox = false;
                            alert("有一項未輸入!");
                        }
                    }
                }
                break;
        }
    }

    function openedit(value) {
        const f_w_fixed_T_I = document.getElementById('f_w_fixed_T_I');
        const revise_tag_form = document.getElementById('revise_tag_form')
        const revise_tag = document.getElementById('revise_tag_checktag_after')
        const select_col = document.querySelector(".select_col");
        const backvalue = document.getElementById('backvalue');

        const disbackvalue = document.getElementById('disbackvalue');

        select_col.style.display = "block";
        f_w_fixed_T_I.value = value;
        backvalue.value = value;
        disbackvalue.value = value;

        if (revise_tag_form.style.display == "none") {
            revise_tag_form.style.display = "block";
            revise_tag.style.display = "none";
            select_col.style.display = "block";


        } else {
            revise_tag_form.style.display = "none";
            revise_tag.style.display = "block";
            select_col.style.display = "none";

        }

    }

    function minustaggroup() {
        const tagLinks = document.querySelectorAll('#tablecontent a');

        // e.appendChild(div);
        tagLinks.forEach(e => {
            e.classList.toggle('deleted');
            if (e.classList.contains('deleted')) {
                var div = document.createElement('div');
                div.className = 'delet_bt';
                div.onclick = function() {
                    del_tag(e.textContent.slice(0, -1));
                }
                div.textContent = '-';

                e.appendChild(div);
                e.addEventListener('click', function(event) {
                    event.preventDefault();
                })
            } else {
                e.removeEventListener('click', function(event) {})
                e.removeChild(e.querySelector('.delet_bt'));
                // console.log(div);
            }
        });


    }

    function del_tag(e) {
        // console.log(e);
        if (confirm('要刪除標籤(' + e + ')嗎?')) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fornt_page_del_tag.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // contentDiv.innerHTML = this.responseText;

                    // const tagLinks = document.querySelectorAll('#tablecontent a');

                    // displayanime(tagLinks);
                    // console.log(this.responseText);
                    location.reload();
                }
            };
            xhr.send("delet=" + e);
        }

    }
</script>
<!-- <script src="OSC.js"></script> -->
<script src="tetx.js"></script>