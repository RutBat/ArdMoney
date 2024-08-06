<?php

include "inc/head.php";

AutorizeProtect();
global $connect;
global $usr;
?>

<head><title>Добавить шаблон</title></head>

<form method="GET" action="adddom.php">

<li  class="list-group-item  justify-content-between align-items-center">

    <div class="input-group mb-3">

        <small  class="form-text text-muted">

            Добавляет ШАБЛОН дома. Просто адрес в который потом добавляется информация (по мере поступления)

        </small>

        <input autofocus list="provlist" type="text" name="adress" class="form-control" required title="Введите от 4 символов" placeholder="Введите адрес">

        <br>

        <input type="hidden" name="vihod" value = "Не указанно">

        <input type="hidden" name="podjezd" value = "Не указанно">

        <input type="hidden" name="lesnica" value = "Не указанно">

        <input type="hidden" name="dopzamok" value = "Не указанно">

        <input type="hidden" name="krisha" value = "Не указанно">

        <input type="hidden" name="oboryda" value = "Не указанно">

        <input type="hidden" name="new" value = "1">

        <?php

        if ($usr['admin'] == '1') {
            echo '</div><small  class="text-danger form-text">Регион</small><select name="region" class="form-select mr-sm-2">';

            $reg = $connect->query("SELECT * FROM region ");

            echo '<small  class="form-text text-muted">В каком регионе: <b>' .

            $usr['region'] .

            '</b></small><br>';

            while ($region = $reg->fetch_object()) {
                if ($usr['region'] == $region->name) {
                    $sel_region = "selected";
                } else {
                    $sel_region = "";
                }

                echo "<option $sel_region value='$region->name'>$region->name</option>";
            }

            echo '</select>';
        } else {
            echo "<input type='hidden' name='region' value='$usr[region]'>";
        }

        ?>

<input type="hidden" name="pon" value = "Не указанно">

<input type="hidden" name="pred" value = "Не указанно">

<input type="hidden" name="phone" value = "Не указанно">

<input type="hidden" name="text" value = "Не указанно">

<input type="hidden" name="klych" value = "Не указанно">

<br>

<div class="d-grid gap-2"><button type="submit" class="btn bg-warning btn-lg">Добавить дом</button></div>
</div>

</li>

</form>

<?php include 'inc/foot.php';
