<?php
?>
<div>
    <audio controls ><source src="./rock/ときのそら「スタースタースタート」 TOKINOSORA - Star,star,start【Official Music Video】.mp3"></audio>
    <audio controls ><source src="./rock/ときのそら「スタースタースタート」 TOKINOSORA - Star,star,start【Official Music Video】.mp3"></audio>
</div>
<div>
    <form action="manegerBD.php" method="post" id='maneger_form'>
        <input type="text" name="M_BD" placeholder="更新的資料庫">
        <input type="text" name="M_BD_C" placeholder="更新的資料欄">
        <input type="text" name="M_BD_information" placeholder="更新的資料">
    </form>
    <button onclick="submit()" type="button" id='manegerBT'>更新BD</button>
</div>
<script>
    function submit(){
        if(confirm("要按嗎")){
            document.getElementById('maneger_form').submit();
            // alert("送了");
        }else{
            alert("還沒送");
        }
    }
</script>