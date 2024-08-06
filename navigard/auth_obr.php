<?php
session_start();
include 'inc/db.php';
global $connect;
$log = trim(htmlspecialchars(htmlentities($_POST['login'])));
$email = trim($_POST['email']);
$pass = trim(htmlspecialchars(htmlentities($_POST['pass'])));

//////////////////ВЫХОД ИЗ СИСТЕМЫ//////////

////////////////////////если авторизация верна то пишем куки, если нет на стр. ошибок///////

if (!empty($log) && !empty($pass)) {
    $us = $connect->query("SELECT * FROM `user` WHERE `name` = '" . $log . "'");

    if ($us->num_rows != 0) {
        $user = $us->fetch_array(MYSQLI_ASSOC);

        $pass_256 = hash('sha256', $pass); // Хэш по алгоритму sha256

        if ($pass_256 == $user['pass']) {
            setcookie('user', $log, time() + 60 * 60 * 24 * 365, '/');
            setcookie('email', $email, time() + 60 * 60 * 24 * 365, '/');
            setcookie('pass', $pass_256, time() + 60 * 60 * 24 * 365, '/');

            $user = $log;

            $date = date("d.m.Y H:i:s");


            echo '<meta http-equiv="refresh" content="0;URL=/">';
        } else {
            echo '<meta http-equiv="refresh" content="0;URL=/auth?err=Пароль указан неверно">';
        }

        exit();
    } else {
        echo '<meta http-equiv="refresh" content="0;URL=/auth.php?err=Пользователь не найден">';

        exit;
    }
} else {
    echo '<meta http-equiv="refresh" content="0;URL=/auth">';
    exit();
}

if (isset($_GET['off'])) {
    session_start();
    setcookie('user', '', 1);
    setcookie('pass', '', 1);
    session_destroy();
    session_unset();

    echo '<meta http-equiv="refresh" content="0;URL=/auth">';

    exit();
}

include 'inc/foot.php';