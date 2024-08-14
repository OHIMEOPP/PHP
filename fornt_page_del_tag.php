<?php
require_once 'function.php';

if (isset($_POST['delet'])) {
    echo $_POST['delet'];
    $del_value = $_POST['delet'];
    $sel = $link->prepare( "DELETE FROM tag_data WHERE `tag_name`=?");
    $sel->bindParam(1, $del_value,PDO::PARAM_STR, 128);
    $sel->execute([$del_value]);
}
