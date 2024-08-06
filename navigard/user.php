<?php

include "inc/head.php";

AutorizeProtect();
global $connect;
global $usr;
?>

    <head>
        <title>Страница пользователя</title>
    </head>

    <ul class="list-group">

        <li class="list-group-item">

            <div id="ava">

                <?php

                $filename = "img/$usr[name].png";

                $tim = filemtime("img/$usr[name].png");


                $ava = file_exists($filename) ? "img/$usr[name].png?r=$tim" : "img/user.png";
                ?>

                <img style="width: 128px; height:128px;" data-toggle="tooltip" data-placement="top"
                     title="Для смены нажмите на изображение" class="rounded-circle mx-auto d-block" src="<?= $ava ?>"
                     alt="">

            </div>
            <div class="d-flex justify-content-center">
                <div id="spiner" class="spinner-border" role="status" style="display:none;"></div>
            </div>
            <div class="press" style="display: none">

                <form name="upload" action="download_img.php" method="POST" ENCTYPE="multipart/form-data">


                    <div class="input-group mb-3">
                        <input type="file" name="userfile" class="form-control" id="inputGroupFile02">
                        <input type="submit" name="upload" class="input-group-text" value="Загрузить"
                               onclick="(document.getElementById('spiner').style.display='block')">
                    </div>
                </form>

            </div>

            <script>
                $('#ava').click(function () {

                    $('.press').show(); // Показывает содержимое диалога.

                });
            </script>

            <?php

            if (isset($_POST['submit'])) {

                $sql = "TRUNCATE log";

                if ($connect->query($sql) === false) {

                    echo "Ошибка: " . $sql . "<br>" . $connect->error;

                }


                redir("user", "0");
            }

            if ($usr['admin'] == 1) {


                ?>
                <div class="d-flex w-100 justify-content-between">

                    <h5 class="mb-1">Логи:</h5>
                </div>
                <div class="text-muted" style="height:100px;overflow-x: auto;">
                    <?php
                    $sql = "SELECT * FROM log ORDER BY id DESC";
                    $res_data = mysqli_query($connect, $sql);
                    while ($row = mysqli_fetch_array($res_data)) {
                        $text = trim($row['log']);
                        echo "$text \n";
                    }
                    ?>
                </div>


                <form action="" method="POST" target="_self">

                    <input class="btn btn-outline-success btn-sm" type="submit" name="submit" value="Очистить логи"/>

                </form>
                <?php
            }


            if ($usr['admin'] == '1') {
                echo '
		<div style="padding: 10px;">
			<img src="img/stats.png?123" alt = "Стат.">
			<a class="text-black" href="/gm">Статистика готовности домов</a>
		</div><br>';
                echo '
		<div style="padding: 0 10px 0 10px;">
			<img src="/img/users.png?!23" alt = "Польз.">
			<a class="text-black" href="/adm_setting.php">Управление пользователями</a>
		</div>';


            }
            ?>


            <small style="margin-top: 1rem;" class="input-group-text text-muted">Ваш логин:

                <b>

                    <?= $usr['name'] ?>

                </b>

            </small>

            <small style="margin-top: 1rem;" class="input-group-text text-muted">Должность:

                <b>

                    <?= $usr['rang'] ?>

                </b>

            </small>

            <small style="margin-top: 1rem;" class="input-group-text text-muted">В каком регионе:

                <b>

                    <?= $usr['region'] ?>

                </b>

            </small>

            <br>

            <b>
                <div class="d-grid gap-2">
                    <a href="/exit.php" class="btn btn-outline-success btn-sm">Выход</a>
                </div>


            </b>

        </li>

    </ul>

<?php include 'inc/foot.php';

?>