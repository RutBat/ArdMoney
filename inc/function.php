<?php
session_start();
include('db.php');

$user = htmlentities($_COOKIE['user']);
global $connect;
$user = $connect->query("SELECT * FROM `user` WHERE `name` = '" . $user . "'");
if ($user->num_rows != 0)
    $usr = $user->fetch_array(MYSQLI_ASSOC);


$used_router123 = $connect->query("SELECT * FROM `used_router` WHERE `technik` = '" . $usr['fio'] . "'");
if ($used_router123->num_rows != 0) {
    $used_router = $used_router123->fetch_array(MYSQLI_ASSOC);
}
function del_mon($id)
{
    global $connect;
    $sql = "DELETE FROM array_montaj WHERE id = '$id'";
    if (mysqli_query($connect, $sql)) {
    } else {
        echo "Error deleting record: " . mysqli_error($connect);
    }
}


function edit_montaj_vidrabot($id_vid_rabot, $name, $new_name, $count)
{


    global $connect;
    $conn = $connect;

    $vid_montaj = $conn->query("SELECT * FROM `vid_rabot` WHERE `name` = '" . $name . "' LIMIT 1");

    if ($vid_montaj->num_rows != 0) {
        $vid_mon = $vid_montaj->fetch_assoc();
        if ($vid_mon['price_tech'] == 0) {
            $pric = 1;
        } else {
            $pric = $vid_mon['price_tech'];
        }
        $price = $pric * $count;
        $sql = "UPDATE array_montaj SET count = '$count', name = '$new_name', price = '$price' WHERE id = '$id_vid_rabot'";
        if ($conn->query($sql) === true) {
            // Здесь может быть дополнительный код, если нужно выполнить какие-то действия после успешного обновления
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }
    }
}
//, $status, $status_baza
function edit_montaj_summa($id_montaj)
{
    global $connect;
    $summa_query = $connect->prepare("SELECT SUM(price) AS count FROM array_montaj WHERE mon_id = ?");
    $summa_query->bind_param("i", $id_montaj);
    $summa_query->execute();
    $summa_result = $summa_query->get_result();
    $record = $summa_result->fetch_assoc();
    $summa = $record['count'];

    $montaj_query = $connect->prepare("SELECT * FROM montaj WHERE id = ?");
    $montaj_query->bind_param("i", $id_montaj);
    $montaj_query->execute();
    $montaj_result = $montaj_query->get_result();
    $mon = $montaj_result->fetch_assoc();

    $tech_codes = array("technik1", "technik2", "technik3", "technik4", "technik5", "technik6", "technik7", "technik8");
    $ebat_code = 0;
    foreach ($tech_codes as $tech_code) {
        if (!empty($mon[$tech_code])) {
            $ebat_code++;
        }
    }



    $kajdomu = round($summa / $ebat_code, 2);
    if ($summa == "") {
        $summa = 0;
    }
    $update_query = $connect->prepare("UPDATE montaj SET summa = ?,  kajdomu = ? WHERE id = ?");
    $update_query->bind_param("isi", $summa, $kajdomu, $id_montaj);
    if ($update_query->execute()) {
        // код для перенаправления на страницу red_index()
    } else {
        echo "Ошибка: " . $update_query->error;
    }
}

function summa_montaj($who, $mon, $years)
{
    global $connect, $usr;
    $months = array(
        'Январь' => 1,
        'Февраль' => 2,
        'Март' => 3,
        'Апрель' => 4,
        'Май' => 5,
        'Июнь' => 6,
        'Июль' => 7,
        'Август' => 8,
        'Сентябрь' => 9,
        'Октябрь' => 10,
        'Ноябрь' => 11,
        'Декабрь' => 12
    );
    $zap_date = $months[$mon];
    $summa = 0;
    for ($i = 1; $i <= 8; $i++) {
        $technik = 'technik' . $i;

        if($usr['name'] == "RutBat"){
            $sql = "SELECT SUM(kajdomu) AS count FROM montaj WHERE $technik = ? AND MONTH(`date`) = ? AND YEAR(`date`) = ?";

        }else{
            $sql = "SELECT SUM(kajdomu) AS count FROM montaj WHERE $technik = ? AND MONTH(`date`) = ? AND YEAR(`date`) = ? AND visible = 1";

        }
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sii", $who, $zap_date, $years);
        $stmt->execute();
        $result = $stmt->get_result();
        $record = $result->fetch_array();
        $summa += $record['count'];
    }
    echo $summa;
}





function summa_cam($who, $mon, $years)
{
    global $connect;
    $months = array(
        'Январь' => 1,
        'Февраль' => 2,
        'Март' => 3,
        'Апрель' => 4,
        'Май' => 5,
        'Июнь' => 6,
        'Июль' => 7,
        'Август' => 8,
        'Сентябрь' => 9,
        'Октябрь' => 10,
        'Ноябрь' => 11,
        'Декабрь' => 12
    );
    $zap_date = $months[$mon];
    $summa = 0;
    for ($i = 1; $i <= 8; $i++) {
        $technik = 'technik' . $i;
        $sql = "SELECT SUM(kajdomu) AS count FROM montaj WHERE $technik = ? AND MONTH(`date`) = ? AND YEAR(`date`) = ? AND text = 'Камеры мирное'";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sii", $who, $zap_date, $years);
        $stmt->execute();
        $result = $stmt->get_result();
        $record = $result->fetch_array();
        $summa += (int)$record['count'];
    }
    return $summa;
}





function num_cam($var1, $var2, $var3)
{
    global $connect;

    $technics = array('technik1', 'technik2', 'technik3', 'technik4', 'technik5', 'technik6', 'technik7', 'technik8');
    $months = array(
        'Январь' => 1,
        'Февраль' => 2,
        'Март' => 3,
        'Апрель' => 4,
        'Май' => 5,
        'Июнь' => 6,
        'Июль' => 7,
        'Август' => 8,
        'Сентябрь' => 9,
        'Октябрь' => 10,
        'Ноябрь' => 11,
        'Декабрь' => 12
    );
    $zap_date = $months[$var2];
    $num_cam = 0;

    foreach ($technics as $technic) {
        
        $results = $connect->query("SELECT * FROM montaj WHERE {$technic} LIKE '{$var1}' AND (MONTH(`date`) = '{$zap_date}' AND YEAR(`date`) = '{$var3}') AND text = 'Камеры мирное'");
        $num_cam += $results->num_rows;
    }
    echo "$num_cam";
}

function sum_cam($var2, $var3)
{
    global $connect;

    $technics = array('technik1', 'technik2', 'technik3', 'technik4', 'technik5', 'technik6', 'technik7', 'technik8');

    $months = array(
        'Январь' => 1,
        'Февраль' => 2,
        'Март' => 3,
        'Апрель' => 4,
        'Май' => 5,
        'Июнь' => 6,
        'Июль' => 7,
        'Август' => 8,
        'Сентябрь' => 9,
        'Октябрь' => 10,
        'Ноябрь' => 11,
        'Декабрь' => 12
    );
    $zap_date = $months[$var2];
    $sum = 0;

    for ($i = 1; $i <= 8; $i++) {
        
        $results = $connect->query("SELECT * FROM montaj WHERE text = 'Камеры мирное'");
        $sum = $results->num_rows;
    }
    echo "$sum";
}







function prim_zp($var1, $var2, $var3)
{
    global $connect;
    $months = array(
        'Январь' => 1,
        'Февраль' => 2,
        'Март' => 3,
        'Апрель' => 4,
        'Май' => 5,
        'Июнь' => 6,
        'Июль' => 7,
        'Август' => 8,
        'Сентябрь' => 9,
        'Октябрь' => 10,
        'Ноябрь' => 11,
        'Декабрь' => 12
    );
    $zap_date = $months[$var2];
    $summa = 0;

    // Получение значения из базы данных
    $sql1 = "SELECT dejurstva FROM user WHERE fio = ?";
    $stmt1 = $connect->prepare($sql1);
    $stmt1->bind_param("s", $var1);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $record1 = $result1->fetch_array();
    $dejurstva = $record1['dejurstva'];


    
    for ($i = 1; $i <= 8; $i++) {
        $technik = 'technik' . $i;
        $sql = "SELECT SUM(kajdomu) AS count FROM montaj WHERE $technik = ? AND MONTH(`date`) = ? AND YEAR(`date`) = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sii", $var1, $zap_date, $var3);
        $stmt->execute();
        $result = $stmt->get_result();
        $record = $result->fetch_array();
        $summa += $record['count'];
    }
    $dejurstva = $dejurstva * 1300;
    $prim_zp = $summa + 24000 + $dejurstva + ($summa + 24000 + $dejurstva) * 0.1;

    echo "<p class='text-body-secondary' style='font-size: 11px; margin-bottom: 0;'>Примерная зп - " . round($prim_zp, 0) . " р.</p>";

}


function num_montaj($var1, $var2, $var3)
{
    global $usr, $connect;

    $technics = array('technik1', 'technik2', 'technik3', 'technik4', 'technik5', 'technik6', 'technik7', 'technik8');
    $months = array(
        'Январь' => 1,
        'Февраль' => 2,
        'Март' => 3,
        'Апрель' => 4,
        'Май' => 5,
        'Июнь' => 6,
        'Июль' => 7,
        'Август' => 8,
        'Сентябрь' => 9,
        'Октябрь' => 10,
        'Ноябрь' => 11,
        'Декабрь' => 12
    );
    $zap_date = $months[$var2];
    $num_montaj = 0;


    if($usr['name'] == "RutBat"){
        foreach ($technics as $technic) {
            $results = $connect->query("SELECT * FROM montaj WHERE {$technic} LIKE '{$var1}' AND (MONTH(`date`) = '{$zap_date}' AND YEAR(`date`) = '{$var3}')");
            $num_montaj += $results->num_rows;
        }
    }else{
    foreach ($technics as $technic) {
        $results = $connect->query("SELECT * FROM montaj WHERE {$technic} LIKE '{$var1}' AND (MONTH(`date`) = '{$zap_date}' AND YEAR(`date`) = '{$var3}') AND visible = 1");
        $num_montaj += $results->num_rows;
    }
}
    echo "$num_montaj";
}




function alrt($text, $why, $tim) //Уведомления
{
?>
    <script>
        setTimeout(function() {
            $('#hidenahoy').fadeOut();
        }, <?= $tim ?>000)
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
    } //Вынужденый костыль (при отсутствии логина в базе приставаивает логин пустышку)
    if (empty($_COOKIE['pass'])) {
        $pass = "TestPass123";
    } //Вынужденый костыль (при отсутствии пароля в базе приставаивает пароль пустышку
    $user = $connect->query("SELECT * FROM `user` WHERE `name` = '" . $name . "' and `pass` = '" . $pass . "' and `reger` = 1");
    $auth = !($user->num_rows == 0);
    return $auth;
}
function access()
{
    global $usr;
    $current_date = date('y-m-d');
    $access = $usr['access_date'];
    $current_date = strtotime($current_date);
    $access = strtotime($access);
    //отключение подписки вообще
    $access = $current_date;
    if ($access < $current_date) {
    ?>
        <div class="card">
            <div class="card-header">
                Важное уведомление!
            </div>
            <div class="card-body">
                <h5 class="card-title">К большому сожалению у вас закончилась подписка. Это не бесплатное ПО. Дата подписки указана
                    в странице пользователя.</h5>
                <p class="card-text">Месячная подписка стоит <b>200р/мес.</b> Все деньги будут уходить в оплату хостинга и кофе.</p>
                <hr>
                <h5>Как оплатить?</h5>
                <br>
                <p class="card-text">Можно скинуть на любую из карт прямым переводом или по номеру телефона через СБП:</p>
                <img src="img/sbp.png" alt="" width="48px"> <b>+7(978)945-84-18</b><br>
                <img src="img/rnkb.png" alt="" width="48px"><b>РНКБ 2200 0202 2350 3329</b><br>
                <a href="https://www.tinkoff.ru/cf/AwmNLM8eFAA"><img src="img/tinkoff.png" alt="" width="48px"><b style="color: black;">Tinkoff(ссылка)</a> 2200 7004 9478 7426</b><br>
                <hr>
                <p class="card-text">После оплаты обязательно напишите любым удобным для вас способом администратору:</p>
                <p class="card-text">Пример текста:</p>
                <p class="fst-italic"><b>Оплатил подписку доступа в приложение ArdMoney, оплачивал через РНКБ в
                        <? echo date('y-m-d h:m'); ?>, моё Ф.И.О. <?= $usr['fio']; ?>
                    </b></p>
                <a href="https://wa.me/79789458418?text=Привет! Я оплатил подписку ArdMoney. Проверь пожалуйста. Меня зовут - <?= $usr['fio']; ?>"><img src="img/whatsapp.png" alt="" width="100px"></a><br><br>
                <a href="https://rutbat.t.me"><img src="img/telegram.png" alt="" width="100px"></a><br><br>
                <a href="httpd://rutbat.t.me"><img src="img/vk.png" alt="" width="100px"></a><br><br>
                <a href="tel:79789458418"><img src="img/sms.png" alt="" width="42px">+7(978)945-84-18</a><br>
                <br>
                После того как пройдет оплата администратор продлит доступ. Имейте терпение продление в ручном режиме.
                <br><br><br>
            </div>
        </div>
    <?
        include('foot.php');
        exit;
    }
}

function month_view($month)
{
    $months = array(
        '01' => 'Январь',
        '02' => 'Февраль',
        '03' => 'Март',
        '04' => 'Апрель',
        '05' => 'Май',
        '06' => 'Июнь',
        '07' => 'Июль',
        '08' => 'Август',
        '09' => 'Сентябрь',
        '10' => 'Октябрь',
        '11' => 'Ноябрь',
        '12' => 'Декабрь',
    );
    return $months[$month];
}


function date_view($date)
{
    $months = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
    $month = '';
    list($year, $number) = explode('-', $date);


    $index = (int)$number - 1;
    if ($index >= 0 && $index < count($months)) {
        $month = $months[$index];
    }


    return $month;
}

function vid_rabot_main($vid, $countid)
{
    global $connect;
    ?>
    <div class="row g-3">
        <div class="col-9" style="width: 74%;">
            <select class="selectpicker form-control dropup" style="background: white;" data-width="100%" data-container="body" title="Часто используемые монтажи" data-hide-disabled="true" data-width="auto" data-live-search="true" name='<?= $vid ?>' data-size="7">
                <?php
                $sql = "SELECT * FROM `vid_rabot` WHERE `prioritet` = '1'  ORDER BY `razdel`";
                $results = mysqli_query($connect, $sql);
                $currentRazdel = '';

                while ($vid_rabot = mysqli_fetch_array($results)) {
                    if ($vid_rabot['razdel'] != $currentRazdel) {
                        // Начало новой группы (нового раздела)
                        if ($currentRazdel != '') {
                            echo '</optgroup>';
                        }
                        echo '<optgroup label="' . $vid_rabot["razdel"] . '">';
                        $currentRazdel = $vid_rabot['razdel'];
                    }
                ?>
                    <option style="color:<?= $vid_rabot['color'] ?>;font-size: 10pt;" data-icon="<?= $vid_rabot['icon'] ?>" value='<?= $vid_rabot['name'] ?>'>
                        <?= $vid_rabot["name"] ?></option>
                <?php
                }
                // Закрываем последнюю группу
                if ($currentRazdel != '') {
                    echo '</optgroup>';
                }
                ?>
            </select>
        </div>
        <div class="col-3 block">
            <input name="<?= $countid ?>" style="
                                    color: #999;
                                    border: 1px solid #bfbdbd;
                                    padding: 1px;
                                    margin: 5px 0px 1px;
                                    height:35px;
                                    background: white;
    " class="form-control form-control" type="text" placeholder="Количество" aria-label="Количество">

        </div>
    </div>
<?
}
function vid_rabot_submain($vid, $countid)
{
    global $connect;
?>
    <div class="row g-3">
        <div class="col-9" style="width: 74%;">
            <select class="selectpicker form-control dropup" data-dropup-auto="false" style="background: white; height: 2rem;" data-width="100%" data-container="body" title="Редко используемые монтажи" data-hide-disabled="true" data-width="auto" data-live-search="true" name='<?= $vid ?>' data-size="7">
                <?php
                $sql = "SELECT * FROM `vid_rabot` WHERE `prioritet` = '0'  ORDER BY `razdel`, `type_kabel`";
                $results = mysqli_query($connect, $sql);
                $currentRazdel = '';

                while ($vid_rabot = mysqli_fetch_array($results)) {
                    if ($vid_rabot['razdel'] != $currentRazdel) {
                        // Начало новой группы (нового раздела)
                        if ($currentRazdel != '') {
                            echo '</optgroup>';
                        }
                        echo '<optgroup label="' . $vid_rabot["razdel"] . '">';
                        $currentRazdel = $vid_rabot['razdel'];
                    }
                ?>
                    <option style="color:<?= $vid_rabot['color'] ?>;font-size: 10pt;" data-icon="<?= $vid_rabot['icon'] ?>" value='<?= $vid_rabot['name'] ?>'>
                        <?= $vid_rabot["name"] ?></option>
                <?php
                }
                // Закрываем последнюю группу
                if ($currentRazdel != '') {
                    echo '</optgroup>';
                }
                ?>
            </select>

        </div>
        <div class="col-3 block">
            <input name="<?= $countid ?>" style="
                                    color: #999;
                                    margin: 5px 0px 1px;
                                    border: 1px solid #bfbdbd;
                                    padding: 1px;
                                    height:35px;
                                    background: white;
    " class="form-control form-control" type="text" placeholder="Количество" aria-label="Количество">

        </div>
    </div>
<?
}

function nav_index($month)
{
    global $usr;
?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding: 0;">
        <div class="container-fluid" style="background: #00000070;">
            <a class="navbar-brand" href="#"></a>
            <div class="navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav" style="flex-direction: row;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
    flex-wrap: wrap;
    align-content: center;
    justify-content: space-around;
    align-items: center;">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $month ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink" style="position: absolute;margin: -4px -5px 0px;">
                            <li><a class="dropdown-item" href="?date=2023-01">Январь</a></li>
                            <li><a class="dropdown-item" href="?date=2023-02">Февраль</a></li>
                            <li><a class="dropdown-item" href="?date=2023-03">Март</a></li>
                            <li><a class="dropdown-item" href="?date=2023-04">Апрель</a></li>
                            <li><a class="dropdown-item" href="?date=2023-05">Май</a></li>
                            <li><a class="dropdown-item" href="?date=2023-06">Июнь</a></li>
                            <li><a class="dropdown-item" href="?date=2023-07">Июль</a></li>
                            <li><a class="dropdown-item" href="?date=2023-08">Август</a></li>
                            <li><a class="dropdown-item" href="?date=2023-09">Сентябрь</a></li>
                            <li><a class="dropdown-item" href="?date=2023-10">Октябрь</a></li>
                            <li><a class="dropdown-item" href="?date=2023-11">Ноябрь</a></li>
                            <li><a class="dropdown-item" href="?date=2023-12">Декабрь</a></li>
                        </ul>
                    </li>
                    <?
                    if ($usr['admin'] == 1) {
                        $status = $usr['admin_view'] == "1" ? "checked" : "";
                        echo '
                                <div class="form-check form-switch">
                                    <input name="admin_viewer" class="form-check-input new_form-check-input" type="checkbox" id="admin_viewer" ' . "$status" . '>
                                    <label class="form-check-label" style = "color: #9ca09a;" for="admin_viewer">Мои</label>
                                </div>';
                    ?>
                        <script>
                            $(document).ready(function() {
                                $('#admin_viewer').change(function() {
                                    var checked = $(this).is(':checked');
                                    var userId = <?= $usr['id'] ?>;
                                    $.ajax({
                                        url: 'update_user.php',
                                        type: 'POST',
                                        data: {
                                            userId: userId,
                                            adminView: checked ? 1 : 0
                                        },
                                        success: function(response) {
                                            console.log(response);
                                            location.reload();
                                        },
                                        error: function(xhr, status, error) {
                                            console.log(xhr.responseText);
                                        }
                                    });
                                });
                            });
                        </script>
                    <?
                    }
                    if ($usr['name'] == 'test' or $usr['name'] == 'test2') {
                        echo '<a href = "demo.php" style = "color: chartreuse;">Инструкция демо аккаунта</a>';
                    }
                    ?>
                    <?php
                    if (!empty(htmlentities($_COOKIE['user']))) {
                    ?>
                        <ul style="float: right;">
                            <li>
                                <a href="user.php">
                                    <i style="font-size: x-large;color: lawngreen;" class="bi bi-house-gear"></i> </a>
                            </li>
                        </ul>
                    <?php
                    } ?>
                </ul>
            </div>
        </div>
    </nav>
<?

}


function demo()
{
    global $connect;
    global $usr;
    if ($usr['demo'] == 1) {
        echo "<div class='alert alert-danger' role='alert'>
Тестовая подписка активна до <b>$usr[access_date]</b> <br>
Подробнее <a href = '/novoreg.php'>ТУТ</a>
</a></b>
</div>";
        $sql = "UPDATE user SET
demo = '0'
WHERE name = '$usr[name]'";
        if ($connect->query($sql) === true) {
        }
    }
}
function modal_delete()
{
    echo '<div class="modal fade" tabindex="-1" role="dialog" id="confirmDeleteModal">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title">Удаление монтажа</h5>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo 'Вы действительно хотите удалить этот монтаж?';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>';
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET) . '&confirmDelete=true" class="btn btn-danger">Удалить</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    // Выводим скрипт, который открывает модальное окно
    echo '<script type="text/javascript">';
    echo '$(document).ready(function() {';
    echo '$("#confirmDeleteModal").modal("show");';
    echo '});';
    echo '</script>';
}
function ava($encodedStr, $mon)
{
    $filename = "img/screen/$encodedStr.png";
    $tim = filemtime($filename);
    $ava = file_exists($filename) ? "img/screen/$encodedStr.png?r=$tim" : "";
    echo '<div id="ava">';
    echo '<span style="background: #e9ab4f85; display:block;"><img src="/img/add_img.png" width="24px"> Прикрепить скрин';

    if (!empty($ava)) {
        echo '<div class="d-grid gap-2">';
        echo '<a id = "div1" href="result.php?vid_id=' . $encodedStr . '&delfoto" class="btn btn-danger btn-sm">Удалить фото</a>';
        echo '</div>';



        echo '<a id = "div2" download href="' . $ava . '">';
        echo '<img style="width: 100%; height: 300px;" data-toggle="tooltip" data-placement="top" title="Для смены нажмите на изображение" class="img-fluid mx-auto d-block" loading="lazy" src="' . $ava . '" alt="">';
        echo '</a>';
        if (isset($_GET['delfoto'])) {
            unlink($filename);
            echo '<script>document.getElementById("div1").style.display = "none";document.getElementById("div2").style.display = "none";</script>';
        }
    }

    echo '</span>';
    echo '</div>';

?>
    <div class="d-flex justify-content-center">
        <div id="spiner" class="spinner-border" role="status" style="display:none;"></div>
    </div>
    <div class="press" style="display: none">
        <form name="upload" action="download_img.php" method="POST" ENCTYPE="multipart/form-data">
            <div class="input-group mb-3" style="margin-bottom: 0rem!important;">
                <input type="hidden" name="id" value="<?= $encodedStr ?>">
                <input type="hidden" name="adress" value="<?= $mon['adress'] ?>">
                <input type="file" name="userfile" class="form-control" id="inputGroupFile02">
                <input type="submit" name="upload" class="input-group-text" value="Загрузить" onclick="(document.getElementById('spiner').style.display='block')">
            </div>
        </form>
    </div>
    <script>
        $('#ava').click(function() {
            $('.press').show(); // Показывает содержимое диалога.
        });
    </script>
<?
}
function gm()
{
    global $usr;

    if ($usr['hidden_mon'] == 0) {
        $check = "checked";
    } else {
        $check = "";
    }
?>
    <div class="m-2 form-check form-switch">
        <input class="form-check-input" type="checkbox" <?= $check ?> role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault">Включить скрытые монтажи</label>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Обработчик изменения состояния чекбокса
            $("#flexSwitchCheckDefault").change(function() {
                if (this.checked) {
                    // Если чекбокс включен, отправляем запрос на сервер
                    $.ajax({
                        type: "POST",
                        url: "update_admin_hidden.php", // Путь к серверному скрипту
                        data: {
                            action: "enable",
                            username: "<?php echo $usr['name']; ?>"
                        },
                        success: function(response) {
                            // Обработка ответа от сервера, если необходимо
                            console.log(response);
                        }
                    });
                } else {
                    // Если чекбокс выключен, отправляем запрос на сервер для отключения
                    $.ajax({
                        type: "POST",
                        url: "update_admin_hidden.php", // Путь к серверному скрипту
                        data: {
                            action: "disable",
                            username: "<?php echo $usr['name']; ?>"
                        },
                        success: function(response) {
                            // Обработка ответа от сервера, если необходимо
                            console.log(response);
                        }
                    });
                }
            });
        });
    </script>



<?
}




function animate()
{

?>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({});
    </script>
<?
}



function delete_mon($id)
{
    global $connect;
    $encodedStr = $_GET["delete"];
    $id = base64_decode($encodedStr);

    // Формируем SQL-запрос на удаление записи с указанным id
    $sql = "DELETE FROM montaj WHERE id = " . $id;
    // Создаем модальное окно с предупреждением об удалении
    // Проверяем, было ли подтверждено удаление
    if (isset($_GET['confirmDelete'])) {
        // Выполняем запрос на удаление
        $result = mysqli_query($connect, $sql);
        // Проверяем, удалена ли запись успешно
        if ($result) {
            // Если да, перенаправляем на страницу без параметра 'delete'
            red_index('index.php');
            exit;
        } else {
            // Если нет, выводим сообщение об ошибке
            echo "Ошибка при удалении записи: " . mysqli_error($connect);
        }
    }
    echo '<div class="modal fade" tabindex="-1" role="dialog" id="confirmDeleteModal">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title">Удаление монтажа</h5>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo 'Вы действительно хотите удалить этот монтаж?';
    echo '</div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>';
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET) . '&confirmDelete=true" class="btn btn-danger">Удалить</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    // Выводим скрипт, который открывает модальное окно
    echo '<script type="text/javascript">';
    echo '$(document).ready(function() {';
    echo '$("#confirmDeleteModal").modal("show");';
    echo '});';
    echo '</script>';
}
function li_month()
{
?>
    <? $dateGod = date("Y"); ?>
    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink" style="position: absolute;margin: -4px -5px 0px;">
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-01">Январь</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-02">Февраль</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-03">Март</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-04">Апрель</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-05">Май</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-06">Июнь</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-07">Июль</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-08">Август</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-09">Сентябрь</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-10">Октябрь</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-11">Ноябрь</a></li>
        <li><a class="dropdown-item" href="?date=<?= $dateGod ?>-12">Декабрь</a></li>
        <?
        // Получаем текущий год
        $previousYear = $dateGod - 1;
        $currentMonth = date('n');
        if ($currentMonth == 1) {
        ?>
            <li><a class="dropdown-item" style="color:red;" href="?date=<?= $previousYear ?>-12">Декабрь <?= $previousYear ?></a></li>

        <?
        }
        ?>

    </ul>
<?
}
function admin_checkbox($id)
{
    global $usr;
    $status = $usr['admin_view'] == "1" ? "checked" : "";
    $gotovo = isset($_GET['complete']) ? "" : "checked";
?>
    <div class="form-check form-switch">
        <input name="admin_viewer" class="form-check-input new_form-check-input" type="checkbox" id="admin_viewer" <?= $status ?>>
        <label class="form-check-label" style="color: #9ca09a;" for="admin_viewer">Мои</label>
    </div>
    <div class="form-check form-switch">
        <input name="complete" class="form-check-input new_form-check-input" type="checkbox" <?= $gotovo ?>>
        <label class="form-check-label" style="color: #9ca09a;" for="complete">ОК</label>
    </div>
    <script>
        function updateURLParam() {
            const checkbox = document.querySelector('input[name="complete"]');
            const isChecked = checkbox.checked;
            const currentURL = new URL(window.location.href);
            const params = currentURL.searchParams;

            if (params.has('complete')) {
                // Если параметр complete уже существует, удаляем его
                params.delete('complete');
            } else {
                // Иначе добавляем его
                params.set('complete', '');
            }

            history.replaceState(null, '', currentURL.href);

            window.location.reload(); // Перезагружаем страницу
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.querySelector('input[name="complete"]');
            checkbox.addEventListener('change', updateURLParam);
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#admin_viewer').change(function() {
                var checked = $(this).is(':checked');
                var userId = <?= $id ?>;
                $.ajax({
                    url: '../update_user.php',
                    type: 'POST',
                    data: {
                        userId: userId,
                        adminView: checked ? 1 : 0
                    },
                    success: function(response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
<?
}
function demo_inst()
{
    global $usr;
    if ($usr['name'] == 'test' or $usr['name'] == 'test2') {
        echo '<a href = "demo.php" style = "color: chartreuse;">Инструкция демо аккаунта</a>';
    }
}
function LiveSearch($inputId, $searchViewsClass, $parentElementId)
{
    echo '<script>';
    echo 'function liveSearch() {';
    echo 'var filter = document.getElementById(\'' . $inputId . '\').value.toUpperCase();';
    echo 'var searchViews = document.getElementsByClassName(\'' . $searchViewsClass . '\');';
    echo 'Array.from(searchViews).forEach(view => {';
    echo 'var value = view.getAttribute(\'data-value\').toUpperCase();';
    echo 'var parentDiv = view.closest(\'' . $parentElementId . '\');';
    echo 'if (parentDiv) {';
    echo 'parentDiv.style.display = value.includes(filter) ? \'\' : \'none\';';
    echo '}';
    echo '});';
    echo '}';
    echo '</script>';
}
function date_rut($input, $format)
{
    $date = DateTime::createFromFormat('Y-m-d', $input);

    if (!$date) {
        $date = DateTime::createFromFormat('Y-m', $input);
        if (!$date) {
            $date = DateTime::createFromFormat('Y', $input);
        }
    }

    if (!$date) {
        return "Неверный формат даты";
    }

    return $date->format($format);
}
