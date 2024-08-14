<?php
require_once 'function.php';
$sel =  "SELECT * FROM `img_data`";
$user = queryimgids($sel);

if(isset($_POST['M_BD']) && isset($_POST['M_BD_C']) && isset($_POST['M_BD_information'])){
$M_BD = $_POST['M_BD'];
$M_BD_C = $_POST['M_BD_C'];
$M_BD_information = $_POST['M_BD_information'];
$_sel = "UPDATE `$M_BD` SET `$M_BD_C`='$M_BD_information'";
// mysqli_query($link,$_sel);
echo  $M_BD . "<br>";
echo  $M_BD_C . "<br>";
echo  $M_BD_information . "<br>";
}

header("Location: indexTWO.php?are=frontpage");