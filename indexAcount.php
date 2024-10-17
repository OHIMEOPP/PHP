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
    <style>
        <?php require_once './css/Account.css'; ?>.mainframe {
            display: flex;
            justify-content: center;
        }

        input {
            box-shadow: none;
            border: 1px solid #0066ff;
            margin: 5px;
            background-color: rgb(255, 215, 215);
            font-size: 1.15em;
            border-radius: 20px;
            height: 48px;
            padding-left: 20px;
            color: #222222;
            padding-bottom: 2px;
            font-weight: normal;
            color: black;
        }

        .mainframe {
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <?php if (isset($_COOKIE['is_login']) && $_COOKIE['is_login'] == true) : //如果是已登入狀態，則跳到登入後頁面
        header('Location: indexTWO.php?are=frontpage'); ?>
    <?php else :
        if (isset($_SESSION['msg'])) { //沒有則回到登入頁面
            echo "<p>" . $_SESSION['msg'] . "</p>";
        }
    ?>

        <div calss="mainframe">
            <form  method="post"><!--已post法送出並導向登入處理-->
                <label for="username">帳號:</label>
                <!--設定post陣列名稱-->
                <input id="account" type="text" value="" placeholder="輸入帳號" ><br>

                <label>密碼:</label>
                <input id="password" style="box-shadow: none; border: 1px solid #0065fd; background-color: rgb(255, 218, 218); font-size: 1.15em;border-radius: 20px; height: 48px; padding-left: 20px; color: #222222; padding-bottom: 2px; font-weight: normal; color: black;" type="passwor" value="" placeholder="輸入密碼"  required='required'><br><br>

                
            </form><button onclick="xhraccount()">按下</button>
            <form action='<?php echo $loginURL; ?>' method="post">
                <input type="text" name="NAME">
                <button type="submit">搜尋密碼</button>

            </form>
            <form action='<?php echo $loginURL; ?>' method="post">
                <label>增加帳號</label>
                <input type="text" name="increaseaccount" id="account"><br>
                <label>增加密碼</label>
                <input type="text " name="increasepassword" id="password">
                <button type="submit">增加</button>
            </form>
        </div>
    <?php endif; ?>
</body>

</html>

<script>
    function xhraccount() {
        const account = document.getElementById("account");
        const password = document.getElementById("password");

        

        var xhr = new XMLHttpRequest();
        var data = "account="+account.value+"&"+"password="+password.value;
        xhr.open("post", "index.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // document.getElementById("txtHint").innerHTML = this.responseText;
                location.reload();
            } 
        }
        
        
        xhr.send(data);
        // xhr.send("account="+ account.value +"&" + "password=");
    }
</script>
<?php
// mysqli_close($link);
ob_end_flush();
?>