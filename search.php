<?php
include("inc/db.php");

if (isset($_POST['search_term'])) {
    $searchTerm = $_POST['search_term'];

    // Формируем SQL-запрос с использованием оператора LIKE
    $sql = "SELECT * FROM `montaj` WHERE `region` = ? AND `adress` LIKE ?";
    $params = [$usr['region'], '%' . $searchTerm . '%'];

    // Подготавливаем SQL-запрос и выполняем его
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
    mysqli_stmt_execute($stmt);
    $res_data = mysqli_stmt_get_result($stmt);

    // Вывод результатов поиска
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
            $font = 'font-family: cursive, "Gill Sans";';
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
        if ($data_tmp == $date_blyat) {
            $str = $row['id'];
            $encodedStr = base64_encode($str);

?>


            <a style="<?= $color ?>" href="result.php?vid_id=<?= $encodedStr ?>">
                <li data-aos="fade-up" data-aos-anchor-placement="top-bottom" class="hui list-group-item d-flex justify-content-between align-items-center aos-init aos-animate <?= $bg ?>" style="padding: 7px 10px 5px 10px;">
                    <label style="color:<?= $color ?>; <?= $font ?>">
                        <small class='form-text '>

                            <?
                            if ($row['dogovor'] == 1) {
                            ?>
                                <img src="/img/dogovor.svg" width="24px">
                            <?
                            }
                            ?>

                            <?= $row['date'] ?></small>
                        <?= $row['adress'] ?>
                        <br>


                        <? if ($row['status'] != 1) {
                        ?>
                            <small class='form-text '>
                                <?php echo $row['technik1'] . $row['technik2'] . $row['technik3'] . $row['technik4'] . $row['technik5']; ?>
                                : <?= $row['text'] ?>
                            </small>
                        <?

                        } ?>




                    </label>
            </a>
            <a href="?delete=<?= $encodedStr ?> ">
                <span class="badge bg-danger rounded-pill">
                    X
                </span>
            </a>
            </li>
            <hr>
<?
        }
    }

    // Закрываем соединение с базой данных
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
