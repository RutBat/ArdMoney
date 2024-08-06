<?php
include "inc/function.php";
AutorizeProtect();
access();
global $connect;
global $usr;
$status = h($_GET['status']);
$mon_id     = h($_GET['mon_id']);
if ($status == "checked") {
    $status = 1;
} else {
    $status = 0;
}
$sql = "UPDATE montaj SET
status = '$status'
WHERE id = '$mon_id'";
if ($connect->query($sql) === true) {
} else {
    echo "Ошибка: " . $sql . "<br>" . $connect->error;
}
var_dump($sql);
 //red_index("result.php?vid_id=$mon_id");