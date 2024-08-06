<?php
include "inc/head.php";
AutorizeProtect();
access();
animate();

?>

<head>
    <title>Список домов</title>

</head>
<?
$month = date_view($_GET['date']);
$date_current = $_GET['date'];
if (!isset($_GET['date'])) {
    $month = month_view(date('m'));
    $date = date("Y-m-d");
    $date_current = substr($date, 0, -3);
}


if ($_GET['status'] == "success") {
    alrt("Монтаж завершен и подвержден!", "success", "2");
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding: 0;">
    <div class="container-fluid" style="background: #00000070;">
        <a class="navbar-brand" href="#"></a>
        <div class="navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav rut_nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $month ?>
                    </a>
                    <?
                    li_month();
                    ?>
                </li>
                <?
                if ($usr['admin'] == 1) {
                    admin_checkbox($usr['id']);
                }
                demo_inst();
                ?>
                <?php
                if (!empty(htmlentities($_COOKIE['user']))) {
                ?>
                    <ul style="float: right;">
                        <li>
                        <a href="search_montaj.php">
                                <img src="/img/search.png" style="width: 40px;padding-bottom: 7px;">
                </a>
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
<script src="https://cdn.jsdelivr.net/mark.js/7.0.0/jquery.mark.min.js"></script>
<?
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
?>

<div style="width: 100%;" class="btn-group" role="group" aria-label="Basic outlined example">
    <a href="montaj.php" class="btn btn-primary btn-lg green_button">Добавить монтаж</a>
</div>

<div class="input-group">
    <span class="input-group-text">Поиск</span>
    <input id="spterm" type="text" aria-label="адрес" class="form-control" oninput="liveSearch()">
</div>
<div id="context">
    <?php
    // Проверяем, был ли передан параметр 'delete'
    if (isset($_GET['delete'])) {
        delete_mon($id);
    }
    if ($_GET['id'] == "ok") {
        alrt("Успешно удаленно", "success", "2");
    }
    if (isset($_GET['complete'])) {
        $view_complete = " AND `status` = '0'";
    }

    // Formulate the SQL query
    $sql = "SELECT * FROM `montaj` WHERE `region` = ? ";
    $params = [$usr['region']];

    if ($usr['rang'] != "Мастер участка") {
        if ($usr['admin_view'] == 1) {
            $sql .= " AND (`technik1` = ? OR `technik2` = ? OR `technik3` = ? OR `technik4` = ? OR `technik5` = ? OR `technik6` = ? OR `technik7` = ? OR `technik8` = ?)" . $view_complete . "  AND visible = 1 ORDER BY `date` DESC, `id` DESC";
            $params = array_merge($params, array_fill(0, 8, $usr['fio']));
        } else {
            if (isset($_GET['current_user'])) {
                $sql .= " AND (`technik1` = ? OR `technik2` = ? OR `technik3` = ? OR `technik4` = ? OR `technik5` = ? OR `technik6` = ? OR `technik7` = ? OR `technik8` = ?)" . $view_complete . "  AND visible = 1 ORDER BY `date` DESC, `id` DESC";
                $params = array_merge($params, array_fill(0, 8, $_GET['current_user']));
            } else {
                if ($usr['admin'] == "1") {
                    if ($usr['name'] == "RutBat") {
                        $sql .= $view_complete . " ORDER BY `id` DESC";

                    }else{
                        $sql .= $view_complete . " AND visible = 1 ORDER BY `id` DESC";
                    }

                } else {
                    $sql .= " AND (`technik1` = ? OR `technik2` = ? OR `technik3` = ? OR `technik4` = ? OR `technik5` = ? OR `technik6` = ? OR `technik7` = ? OR `technik8` = ?)" . $view_complete . "  AND visible = 1 ORDER BY `date` DESC, `id` DESC";
                    $params = array_merge($params, array_fill(0, 8, $usr['fio']));
                }
            }
        }
    } else {
        $sql .= $view_complete . " ORDER BY `id` DESC";
    }
    // Prepare the SQL query and execute it
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
    mysqli_stmt_execute($stmt);
    $res_data = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($res_data)) {
        $date = new DateTime;
        [$h, $m, $s] = explode(':', $date->format('H:i:s.u'));
        $cur_date = $h * 3600 + $m * 60 + $s; //секунды от полуночи
        $test = time() - strtotime($row['date']); //Секунды от времени добавления в базу
        $color = "#000";
        $color = ($cur_date < $test) ? "black" : "red";
        // Изначально цвет фона устанавливается на белый
        $bg = "#fff";
        // Если статус равен 1, то меняем цвет на зеленый и выделяем жирным шрифтом
        if ($row['status'] == 1) {
            $bg = "success_color";
        }
        // Если статус в базе равен 1, то меняем цвет на желтый и выделяем обычным шрифтом
        elseif ($row['status_baza'] == 1) {
            $bg = "baza_color";
            $font = 'font-weight: normal;';
        }
        // Иначе сохраняем значения по умолчанию
        else {
            $font = 'font-family: inherit;';
        }
        $data_tmp = substr($row['date'], 0, -3);
        if ($data_tmp == $date_current) {
            $str = $row['id'];
            $encodedStr = base64_encode($str);



            echo '<div id="skrivat">';
            echo "<a id='search_view' class='search_view' style='$color' href='result.php?vid_id=$encodedStr' data-value='" . htmlspecialchars($row['adress']) . "'>";
            echo "<li class='hui list-group-item d-flex justify-content-between align-items-center $bg' style='padding: 7px 10px 5px 10px;'>";
            echo "<label style='color: $color; $font;'>";
            echo "<small class='form-text '>";
            if ($row['dogovor'] == 1) {
                echo '<img src="/img/dogovor.svg" width="24px">';
            }
            echo $row['date'];
            echo '</small>';
            echo $row['adress'];
            echo '<br>';
            if ($row['status'] == 0) {
                echo "<small class='form-text '>";
                echo $row['technik1'] . $row['technik2'] . $row['technik3'] . $row['technik4'] . $row['technik5'];
                echo ":";
                echo $row['text'];
                echo '</small>';
            }
            echo '</label>';
            echo '</a>';
            echo "<a href='?delete=<?= $encodedStr ?> '>";
            echo ' <span class="badge bg-danger rounded-pill">X</span>';
            echo '</li>';
            echo '</a>';
            echo "<hr class='hr_index'>";
            echo ' </div>';
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($connect);

    echo '</div>';
    echo '</div>';
    // живой поиск
    //LiveSearch('ПОЛЕ ВВОДА spterm', 'ГДЕ ИСКАТЬ search_view', 'БЛОК ДЛЯ СКРЫТИЯ#skrivat');
    // data-value в блоке где будет поиск должен содержать
    // в себе имя или что то похожее для поиска соответствий
    //например
    //data-value="' . htmlspecialchars($row['name']) . '"
    LiveSearch('spterm', 'search_view', '#skrivat');
    include 'inc/foot.php';
    ?>