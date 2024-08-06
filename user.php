<?php
include "inc/head.php";
access();
AutorizeProtect();
global $connect;
global $usr;
?>

<head>
    <title>Страница пользователя</title>
</head>
<?
$month = date_view($_GET['date']);
$date_blyat = "$_GET[date]";
if (!isset($_GET['date'])) {
    $month = date('m');
    $year = date('y');
    $month = month_view(date('m'));
    $date = date("Y-m-d");
    $date_blyat = substr($date, 0, -3);
}
$year = date('y');
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
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-01">Январь</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-02">Февраль</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-03">Март</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-04">Апрель</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-05">Май</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-06">Июнь</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-07">Июль</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-08">Август</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-09">Сентябрь</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-10">Октябрь</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-11">Ноябрь</a></li>
                        <li><a class="dropdown-item" href="?date=<?= $year ?>-12">Декабрь</a></li>
                    </ul>
                </li>
                <?php
                if (!empty(htmlentities($_COOKIE['user']))) {
                ?>
                    <ul style="float: right;">
                        <li>
                            <a href="user.php">
                                <img src="/img/home.png" style="width: 40px;padding-bottom: 7px;">
                            </a>
                            <a href="search_montaj.php">
                                <img src="/img/search.png" style="width: 40px;padding-bottom: 7px;">
                </a>
                        </li>
                    </ul>
            </ul>
        <?php
                } ?>
        </div>
    </div>
    </div>
</nav>
<!-- <div class="d-grid gap-2">
        <a class="btn btn-danger" href="ins.php">Инструкция</a>
    </div> -->
<ul class="list-group">
    <li class="list-group-item" style="padding: 0; border: none;">

        <?
        if ($usr['name'] == "RutBat") {
            echo '<img class="mx-auto d-block w-100" src="img/user_RutBat.png">';
        } elseif ($usr['name'] == "Игорь") {
            echo '<img class="mx-auto d-block w-100" src="img/user_Игорь.png">';
        } elseif ($usr['name'] == "kovalev") {
            echo '<img class="mx-auto d-block w-100" src="img/user_Вова.png">';
        } elseif ($usr['name'] == "grisnevskijp@gmail.com") {
            echo '<img class="mx-auto d-block w-100" src="img/user_Паша.png">';
        } elseif ($usr['name'] == "Юра") {
            echo '<img class="mx-auto d-block w-100" src="img/user_Юра.png">';
        } else {
            echo '<img class="mx-auto d-block w-100" src="img/user_logo.webp?123">';
        }


        ?>




        <?
        if ($usr['admin'] == "1" || $usr['name'] == "RutBat") {
        ?>
            <table class="table" style="margin-bottom: 0rem;">
                <thead>
                    <tr>
                        <th scope="col">Техник</th>
                        <th scope="col">Монтажи</th>
                        <th scope="col">Сумма денег</th>
                    </tr>
                </thead>
                <tbody style="background: rgb(222,252,186);
background: linear-gradient(180deg, rgba(222,252,186,0.8155637254901961) 5%, rgba(224,255,203,0.6362920168067228) 16%, rgba(229,252,217,0.8015581232492998) 74%);">
                    <?


                    $sql = "SELECT * FROM `user` WHERE `region` = '" . $usr['region'] . "' ORDER BY `id` desc";
                    $res_data = mysqli_query($connect, $sql);
                    while ($tech = mysqli_fetch_array($res_data)) {


                    ?>
                        <tr>
                            <td><a style="color: black;font-weight: 700;font-size: small;" href="index.php?current_user=<?= $tech['fio'] ?>"><?= $tech['fio'] ?></a></td>
                            <td><?
                                num_montaj("$tech[fio]", "$month", 2024);
                                ?></td>
                            <td><?
                                summa_montaj("$tech[fio]", "$month", 2024);
                                ?> р.
                                <?php
                                // Получаем текущую дату
                                $currentDate = new DateTime();

                                // Получаем текущий месяц в числовом формате
                                $currentMonth = intval($currentDate->format('n')); // n - формат месяца без ведущего нуля

                                // Массив, связывающий текстовые названия месяцев с их числовыми представлениями
                                $monthNames = [
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
                                    'Декабрь' => 12,
                                ];

                                // Получаем числовое представление выбранного месяца (предполагается, что $month это текстовое название месяца)
                                $selectedMonth = $monthNames[$month] ?? 0; // Если месяц не найден в массиве, по умолчанию 0

                                // Получаем последний день текущего месяца
                                $lastDayOfMonth = new DateTime('last day of this month');

                                // Вычисляем разницу между текущей датой и последним днем месяца в днях
                                $daysUntilEndOfMonth = $currentDate->diff($lastDayOfMonth)->days;

                                // Если $month не является текущим месяцем и осталось менее или равно 7 дням до конца месяца, либо $month отличается от текущего месяца, выполняем функцию prim_zp
                                if ($selectedMonth !== $currentMonth || $daysUntilEndOfMonth <= 7) {
                                    echo "<u><a style = 'color: #1ba11b;' href = 'zp.php?fio=$tech[fio]' >";
                                    prim_zp("$tech[fio]", "$month", 2024);
                                    echo '</a></u>';
                                }
                                ?>


                            </td>
                        </tr>
                    <?
                    }
                    ?>
                </tbody>
            </table>
        <?
        } else {
        ?>
            <table class="table" style="margin-bottom: 0rem;">
                <thead>
                    <tr>
                        <th scope="col">Техник</th>
                        <th scope="col">Монтажи</th>
                        <th scope="col">Сумма денег</th>
                    </tr>
                </thead>
                <tbody class="td_user">
                    <tr>
                        <td><?= $usr['fio']; ?></td>
                        <td style="color:red;"><?
                                                num_montaj("$usr[fio]", "$month", 2024);
                                                ?></td>
                        <td><?
                            summa_montaj("$usr[fio]", "$month", 2024);
                            ?> р.</td>
                    </tr>
                </tbody>
            </table>
        <?
        }


        //Отключение подписки
        ?>



        <!-- <div class="alert alert-info" role="alert">
            Подписка активна до: <b><? //= $usr['access_date']
                                    ?></b>
        </div> -->
        <?php






        if ($usr['name'] == 'RutBat') {
            
            echo'
            <div class="alert alert-info" role="alert">
            <b><a href="gm.php">GM ПАНЕЛЬ</a></b>
            </div>'; 
        }

        // if ($usr['admin_view'] == 0) {
        ?>


        <div class="alert alert-success" style="    padding: 0rem 25%;border-radius: 0;" role="alert">
            За прошлый год
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <b><a href="user_arhiv.php" style="color:black;">Суммы монтажей</a></b>
                </div>
                <div class="col">
                    <b><a href="arhiv.php" style="color:black;">Архив монтажей</a></b>
                </div>

                <div class="col">
                    Регион: <b><?= $usr['region'] ?></b>
                </div>

            </div>
        </div>
        <?
        //}
        ?>
        <div class="alert alert-info" role="alert">
            Ваш логин: <b><?= $usr['name'] ?></b>
        </div>
        <div class="alert alert-success" role="alert" style="padding: 0px 20px 0px;">
            Приложение для Android <a href="ardmoney.apk" class="alert-link"><img src="img/android.png" style="width: 32px;padding-bottom: 18px;">ArdMoney</a>.
        </div>
        <div style="background: #000000cc;">
            <b><a href="https://nav.ardmoney.ru">
                    <img src="img/navigard.png" style="
    width: 50%;
    padding: 10px;
"></a></b>
        </div>


        <br>
        <b>
            <div class="d-grid gap-2">
                <a href="/exit.php" class="btn btn-outline-success btn-sm">Выход</a>
            </div>
        </b>
    </li>
</ul>
</div>
<?php include 'inc/foot.php';
?>