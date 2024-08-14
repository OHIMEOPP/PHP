<?php
require_once 'function.php';
// include 'function.php';
// $testsel =  "SELECT * FROM `tag_data` WHERE `creat_user_id`='$user_id'";
// $testtag = querytagids($testsel);

// $array = [];
// foreach($testtag as $f => $g){
//     array_push($array, $g['tag_name']);
// }
// $uniqueArray = array_unique($array);
// $duplicates = array_diff_assoc($array, $uniqueArray);
// print_r($array);
?>
<div class="imgAre_out">
    <div class="imgAre">
        <div>
            <form method="post" id="from_s">
                <select name="select_sort" id="select_sort" onchange="showsortimg(this.value)">

                    <option value="上傳日期">上傳日期</option>
                    <option value="ID">ID</option>
                    <option value="圖片名稱">圖片名稱</option>
                    <option value="人物">人物</option>
                    <option value="團體">團體</option>
                    <option value="作者">作者</option>
                    <option value="public">全體公開圖</option>
                    <option value="人物未修改">人物未修改</option>
                    <option value="團體未修改">團體未修改</option>
                    <option value="作者未修改">作者未修改</option>
                    <option value="其他標籤未修改">其他標籤未修改</option>
                </select>
            </form>
            <a href="#">圖片名稱</a>


            <div id="timeblock">
            </div>
        </div>
        <?php
        echo "<div class='content' id='content'>";

        echo "<div>";
        ?>
    </div>
</div>
<style>
    <?php require_once './css/imageAre.css' ?>
</style>
<script>
    current_select();

    // select_sort.addEventListener('change', function(e) {
    //     document.getElementById("from_s").submit();
    // });

    function carousel1() {
        var timeblock = document.getElementById("timeblock");
        document.getElementById("timeblock").innerText = "<?php echo currentTime() ?>";
        console.log('<?php echo currentTime() ?>')
    }
    var timer = setInterval(carousel1, 1000);

    function current_select() {
        const selectElement = document.getElementById('select_sort');

        // 在用户选择选项时保存选中值到本地存储
        selectElement.addEventListener('change', function(event) {
            localStorage.setItem('selectedOption', event.target.value);
        });

        // 在页面加载时检查本地存储并设置选中项
        document.addEventListener('DOMContentLoaded', function() {
            const selectedOption = localStorage.getItem('selectedOption');
            if ("排序:" + selectedOption != (selectElement.value)) {
                selectElement.value = selectedOption;
                showsortimg(selectElement.value);
            }
        });
    }

    function showsortimg(str) {

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(this.responseText, 'text/html');

                var contentDiv = doc.querySelector('.content');

                document.getElementById("content").innerHTML = contentDiv.innerHTML;

            }
        }
        var tag = "<?php echo !empty($_GET['tag']) ? $_GET['tag'] : json_encode(null) ; ?>";//&tag="+ tag
        var pagecontent = "fly.php?page=<?php echo $_GET['page']; ?>";
        console.log(tag);
        xmlhttp.open("POST", pagecontent + "&tag="+ tag, true);

        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xmlhttp.send("select_sort=" + str);
        // window.location.href = "indexTWO.php?page=1";
    }

    function clr_dom() {
        localStorage.getItem('selectedOption') = '';
        console.log("bff");
    }
</script>