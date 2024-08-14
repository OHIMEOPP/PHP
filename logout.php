<?php
    $_myURL2 = "indexAcount.php";

    session_start();

    session_unset();
    // setcookie("is_login", "", time() - 3600);
    header("Location: $_myURL2");
?>