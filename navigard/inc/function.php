<?php
session_start();
include('inc/db.php');
function button($var)
{
    echo '<div class="d-grid gap-2">';
    echo "$var";
    echo '</div>';
}
function alrt($text, $why, $tim) //Уведомления
{
    ?>
    <script>
        setTimeout(function () {
            $('#hidenahoy').fadeOut();
        }, <?=$tim?>000)
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <div id="hidenahoy" role="alert">
        <div class="alert alert-<?= $why ?>">
            <?= $text ?>
        </div>
    </div>
    <?php
}
function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
function h($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
function redirect($url) //Редирект с анимацией
{
    $url = htmlentities($url);
    echo '<div class="d-flex justify-content-center" style = "padding: 25% 25%;height: 70%;">';
    echo '<div class="loader">';
    echo '</div>';
    echo '</div>';
    echo '<meta http-equiv="refresh" content="0;URL=' . "$url" . '">';
}
function red_index($url) // редирект моментальный
{
    $url = htmlentities($url);
    echo '<meta http-equiv="refresh" content="0;URL=' . "$url" . '">';
}
function redir($url, $tim) // редирект с задержкой
{
    $url = htmlentities($url);
    $tim = htmlentities($tim);
    ?>
    <meta http-equiv="refresh" content="<?= $tim ?>;URL=<?= $url ?>">
    <?php
}
function preloader() //Первый вход на сайт (прелоадер)
{
    ?>
    <div id="p_prldr">
        <div class="contpre">
            <br>
            <img src="../img/logo.png" alt="Логотип загрузки">
            <br>
            <br>
            <br>
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status"></div>
            </div>
        </div>
    </div>
    <?
}
$user = htmlentities($_COOKIE['user']);
global $connect;
$user = $connect->query("SELECT * FROM `user` WHERE `name` = '" . $user . "'");
if ($user->num_rows != 0)
    $usr = $user->fetch_array(MYSQLI_ASSOC);
function AutorizeProtect() // Прошел ли пользователь проверку
{
    if (checkAccess() === false) {
        ?>
        <script type="text/javascript">
            document.location.replace("/auth.php");
        </script>
        <?
        exit;
    }
}
function checkAccess() // Проверка пользователя на авторизацию через базу данных
{
    global $connect;
    $name = $_COOKIE['user'];
    $pass = $_COOKIE['pass'];
    if (empty($_COOKIE['user'])) {
        $name = "TestUser123";
    }//Вынужденый костыль (при отсутствии логина в базе приставаивает логин пустышку)
    if (empty($_COOKIE['pass'])) {
        $pass = "TestPass123";
    }//Вынужденый костыль (при отсутствии пароля в базе приставаивает пароль пустышку
    $user = $connect->query("SELECT * FROM `user` WHERE `name` = '" . $name . "' and `pass` = '" . $pass . "' and `reger` = 1");
    $auth = !($user->num_rows == 0);
    return $auth;
}
function out_sel($val1, $val2, $val3)//функция вывода результата из базы данных (selected)
{
    global $connect;
    $val1 = htmlentities($val1);
    $val2 = htmlentities($val2);
    $color = $val3 == "Регион" ? "text-danger" : "text-muted";
    $results = $connect->query("SELECT * FROM adress WHERE adress LIKE '$val2' ");
    while ($row = $results->fetch_object()) {
        echo "<small  class='form-text $color'>$val3</small><select name='$val1' class='form-select mr-sm-2'>";
        $krish = $connect->query("SELECT * FROM $val1");
        while ($krisha = $krish->fetch_object()) {
            if ($row->$val1 == $krisha->name) {
                $sel_krisha = "selected";
            } else {
                $sel_krisha = "";
            }
            echo "<option $sel_krisha value='$krisha->name'>$krisha->name</option>";
        }
        echo '</select>';
    }
}
function out_in($val1, $val2, $val3)//функция вывода результата из базы данных (input)
{
    global $connect;
    $val1 = htmlentities($val1);
    $val2 = htmlentities($val2);
    $val3 = htmlentities($val3);
    $results = $connect->query("SELECT * FROM adress WHERE adress LIKE '$val2' ");
    while ($row = $results->fetch_object()) {
        if($val1 == 'phone'){
            ?>
            <small class="form-text text-muted"><?= $val3 ?></small>
            <input name="<?= $val1 ?>" type="text" class="form-control bfh-phone" data-format="+7(ddd)ddd-dd-dd" value="<?= $row->$val1 ?>"
            <?
        }else{
            ?>
            <small class="form-text text-muted"><?= $val3 ?></small>
            <input name="<?= $val1 ?>" type="text" class="form-control" value="<?= $row->$val1 ?>"
            <?
        }
        empty($row->$val1) ? $row->$val1 = $val3 : '';
        ?>
               placeholder="<?= $row->$val1 ?>"
        <?
        if ($val1 == "adress") {
            echo 'style="display: -webkit-inline-box;width: 91%;">';
        } else {
            ?>
            >
            <?
        }
    }
}