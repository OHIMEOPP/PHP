<?php
ob_start();
$loginURL = "./index.php";
require_once 'function.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <!--style是css做修飾-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        <?php
        require_once './css/main.css';
        require_once './css/Account.css';

        ?>
    </style>
</head>

<body>
    <?php if (isset($_COOKIE['is_login']) && $_COOKIE['is_login'] == true): //如果是已登入狀態，則跳到登入後頁面
            header('Location: indexTWO.php?are=frontpage'); ?>
    <?php else:
            if (isset($_SESSION['msg'])) { //沒有則回到登入頁面
                echo "<p>" . $_SESSION['msg'] . "</p>";
            }
            ?>

        <div calss="mainframe">
            <div class="topcontainer">
                <a href="indexAcount.php">OHIMEOPP素材網</a>
            </div>
            <div class="container1">
                <div class="logintitle">OHIMEOPP素材網</div>
                <div class="login">
                    <form method="post" id="login"><!--已post法送出並導向登入處理-->
                        <!--設定post陣列名稱-->
                        <input id="account" type="text" value="" placeholder="輸入帳號" required='required'>
                        <div class="tab"></div>
                        <div class="passwordzone">
                            <input id="password" type="password" value="" placeholder="輸入密碼" required='required'><br>
                            <a href="#">
                                <i class="material-icons" onclick="swdisplay('password')">visibility</i>
                            </a>
                        </div>
                        <input type="submit" value="登入" class="submit" onclick="xhraccount()">
                        <div class="switch-register">
                            還沒有帳號嗎?<a onclick="swdisplay('signzone')">註冊帳號</a>
                        </div>
                    </form>
                    <!-- <form action='<?php echo $loginURL; ?>' method="post">
                        <input type="text" name="NAME">
                        <button type="submit">搜尋密碼</button>

                    </form> -->

                </div>
                <div>


                    <form action='<?php echo $loginURL; ?>' method="post" id="signzone" style="display:none">
                        <div class="switch-login">
                            <a onclick="swdisplay('signzone')" style="cursor: pointer">返回登入</a>
                        </div>
                        <input type="text" name="increaseaccount" id="account" placeholder="輸入帳號">
                        <div class="tab"></div>
                        <input type="text " name="increasepassword" id="password" placeholder="輸入密碼">
                        <div class="tab"></div>
                        <button type="submit">增加</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>

<script>
    function xhraccount() {
        const account = document.getElementById("account");
        const password = document.getElementById("password");



        var xhr = new XMLHttpRequest();
        var data = "account=" + account.value + "&" + "password=" + password.value;
        xhr.open("post", "index.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // document.getElementById("txtHint").innerHTML = this.responseText;
                location.reload();
            }
        }


        xhr.send(data);
        // xhr.send("account="+ account.value +"&" + "password=");
    }
    function swdisplay(item) {
        const password = document.getElementById("password");
        const signzon = document.getElementById("signzone");
        const loginzon = document.getElementById("login");
        switch (item) {
            case "password":
                if (password.type == "password") {
                    password.type = "text";
                }

                else {
                    password.type = "password";
                }
                break;
            case "signzone":
                if (signzon.style.display == "none") {
                    loginzon.style.display = "none";
                    signzon.style.display = "block";
                }
                // console.log(signzon);
                else {
                    signzon.style.display = "none";
                    loginzon.style.display = "block";
                }
                break;
        }

    }
</script>
<?php
// mysqli_close($link);
ob_end_flush();
?>