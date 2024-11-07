<?php
require_once 'function.php';
?>
<div class="imgAre_out">
    <div class="imgAre">
        <div class="select_sort_area">
            <form method="post" id="from_s">
                <select name="select_sort" id="select_sort" onchange="showsortimg(this.value, null)">
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
            <label class="sort_desc">
                <input type="button" id="sort_desc" onclick="showsortimg(null, this.value)" value="desc"
                    style="display:none">
                <i class="material-icons" id="arrow">arrow_upward </i>
            </label>
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

    function current_select() {
        const selectElement = document.getElementById('select_sort');

        // 在页面加载时检查本地存储并设置选中项
        document.addEventListener('DOMContentLoaded', function () {
            const selectedOption = localStorage.getItem('selectedOption');
            if ("排序:" + selectedOption != (selectElement.value)) {
                selectElement.value = selectedOption;
                showsortimg(selectElement.value,localStorage.getItem('sortDES'));
            }
        });
    }

    function showsortimg(str, sortDES) {
        const selectElement = document.getElementById('select_sort');
        const sort_desc = document.getElementById('sort_desc');
        const arrow =document.getElementById('arrow');
        // 在用户选择选项时保存选中值到本地存储
        // const sortDES = localStorage.getItem('sortDES');
        // const arrow =document.getElementById('arrow');

        if (sortDES == null) {

            selectElement.addEventListener('change', function (event) {
                localStorage.setItem('selectedOption', event.target.value);
            });
            sortDES = localStorage.getItem('sortDES');
            console.log("sorDES = " + sortDES);
            console.log("str = " + str);
        }
        if (str == null) {
            str = localStorage.getItem('selectedOption');
            if (sortDES === 'desc') {
                sort_desc.value = 'asc';
                localStorage.setItem('sortDES', sortDES);
                arrow.textContent = 'arrow_downward';
            } else {
                sort_desc.value = 'desc';
                localStorage.setItem('sortDES', sortDES);
                arrow.textContent = 'arrow_upward';
            }
            console.log("sorDES = " + sortDES);
            console.log("str = " + str);
        }
        if (sortDES === 'desc') {
                arrow.textContent = 'arrow_downward';
            } else {
                arrow.textContent = 'arrow_upward';
            }



        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(this.responseText, 'text/html');

                var contentDiv = doc.querySelector('.content');

                document.getElementById("content").innerHTML = contentDiv.innerHTML;

            }
        }
        var tag = "<?php echo !empty($_GET['tag']) ? $_GET['tag'] : json_encode(null); ?>";//&tag="+ tag
        var pagecontent = "fly.php?page=<?php echo $_GET['page']; ?>";
        // console.log(tag);
        xmlhttp.open("POST", pagecontent + "&tag=" + tag, true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xmlhttp.send("select_sort=" + str + "&sortDES=" + sortDES);
        // window.location.href = "indexTWO.php?page=1";
    }


    function clr_dom() {
        localStorage.getItem('selectedOption') = '';
        // console.log("bff");
    }
</script>