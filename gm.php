<?php
include "inc/head.php";
AutorizeProtect();
access();
animate();
if($_COOKIE['user'] != "RutBat"){
    echo'Тебе тут не место!!!';
    exit;
}
?>

<head>
    <title>RUTBAT ПАНЕЛЬ</title>
</head>

<?
$month = date_view($_GET['date']);
$date_current = $_GET['date'];
if (!isset($_GET['date'])) {
    $month = month_view(date('m'));
    $date = date("Y-m-d");
    $date_current = substr($date, 0, -3);
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding: 0;">
    <div class="container-fluid" style="background: #00000070;">
        <a class="navbar-brand" href="#"></a>
        <div class="navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav rut_nav">
                <?php
                if (!empty(htmlentities($_COOKIE['user']))) {
                ?>
                    <ul style="float: right;">
                        <li>
                            <a href="user.php">
                                <img src="/img/home.png" style="width: 40px;padding-bottom: 7px;">
                            </a>
                        </li>
                    </ul>
                <?php
                } ?>
            </ul>
        </div>
    </div>
</nav>




<div class="alert alert-danger" role="alert">
<b><a href="https://ardmoney.ru:1488">Управление RutVPN</a></b>
</div>
<div class="alert alert-success" role="alert">
<b><a href="https://ardmoney.ru:8888">Управление FastPanel</a></b>
</div>
<div class="alert alert-warning" role="alert">
<b><a href="adm_setting.php">Управление пользователями</a></b>
</div>
<div class="alert alert-danger" role="alert">
<b><a href="adm_vidrabot.php">Управление видами работ</a></b>
</div>
<div class="alert alert-success" role="alert">
<b><a href="rutdown.php">Загрузить АПК</a></b>
</div>
<div class="alert alert-info" role="alert">
  Бекап сайта <a href="/backup/backup_last.zip" class="alert-link"><img width="32px" src="/img/backup.png" alt=""></a>
  Бекап базы <a href="/backup/backup_last.sql" class="alert-link"><img width="32px" src="/img/sql.png" alt=""></a>
</div>






<?php
include 'inc/foot.php';
?>
