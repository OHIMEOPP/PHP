<?php
require_once 'function.php';

$img_id = $_GET['img_id'];
$sel = "DELETE FROM `img_data` WHERE `id` = {$img_id} && `creat_user_id` = {$user_id} ";
$link->query($sel);
echo $sel;
header("Location: indexTWO.php?are=frontpage");


?>

