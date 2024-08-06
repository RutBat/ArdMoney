<?php
include "inc/function.php";
AutorizeProtect();
access();
global $connect;
global $usr;
$id        = h($_GET['id']);
$name      = h($_GET['name']);
$region    = h($_GET['region']);
$email     = h($_GET['email']);
$admin   = empty(h($_GET['admin'])) ? 0 : h($_GET['admin']);
if ($_GET['admin'] == 'on') {
    $admin = 1;
}
//////////////////////////////////////////////////////////////////////////////////////////////
$results    = $connect->query("SELECT * FROM user WHERE id LIKE '$id' LIMIT 1");
$this_user = $results->num_rows == 1 ? $results->fetch_array(MYSQLI_ASSOC) : '';
//Если данных нет то осталяем без изменений, если есть добавляем их в переменную
$email      = empty(h($_GET['email'])) ? $this_user['email'] : h($_GET['email']);
$name       = empty(h($_GET['name'])) ? $this_user['name'] : h($_GET['name']);
$user  = $usr['name'];
$date  = date("d.m.Y H:i:s");
$text2 = "отредактировал пользователя - $email";
$log   = "Пользователь $user $text2";
$zap   = "INSERT INTO log (kogda, log)
VALUES (
'$date',
'$log'
)";
if ($connect->query($zap) === false) {
    echo "Ошибка: " . $zap . "<br>" . $connect->error;
}
$sql = "UPDATE user SET
name = '$name',
email = '$email',
admin = '$admin'
WHERE id = '$id'";
if ($connect->query($sql) === true) {
    red_index("/adm_setting.php?success&id=$email");

    exit;
} else {
    echo "Ошибка: " . $sql . "<br>" . $connect->error;
}
include 'inc/foot.php';
