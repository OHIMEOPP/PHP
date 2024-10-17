<?php
    $_myURL2 = "indexAcount.php";

    session_start();

    session_unset();
    setcookie("is_login", "", time() - 60 * 60 * 24, "/");
    setcookie("uuid", "", time() - 60 * 60 * 24, "/");
    header("Location: $_myURL2");
?>