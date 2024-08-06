<?php
session_start();
include "inc/head.php";
AutorizeProtect();
global $connect;
global $usr;
$adress = trim(h($_GET['adress']));
?>

<head>
	<title>Информация о доме
		<?= $adress ?>
	</title>
</head>
<?php
if ($adress == "pon" || $adress == "Pon") {
    echo "</div>";
    redirect("all.php?tech=pon");
    include "inc/foot.php";
    exit();
}

if ($adress == "ethernet" || $adress == "Ethernet") {

    echo "</div>";

    redirect("all.php?tech=ethernet");

    include "inc/foot.php";

    exit();
}

if ($adress == "Complete" || $adress == "complete" || $adress == "Готово" || $adress == "готово") {

    echo "</div>";
    redirect("all.php?tech=complete");

    include "inc/foot.php";

    exit();
}

////////////Если режим редактирования то меняем на противоположный

if (isset($_GET['viewer'])) {

    $status = $usr['viewer'] == 0 ? '1' : '0';

    $sql = "UPDATE user SET

viewer = '$status'

WHERE name = '$usr[name]'";

    $connect->query($sql);

    redir("$_SERVER[HTTP_REFERER]", "0");

    exit;
}

///////////////////////////////////////////////////////

$res = $connect->query("SELECT * FROM adress WHERE adress LIKE '%$adress%'");

if ($res->num_rows == 0) {

    $err = '<b><center>Адреса нет в базе. Попробуйте еще.</center></b> <br>

Вы попали на эту страницу потому что ваш введенный адрес отсутствует в системе.<br>

Вы можете предпринять следующие действия:<br>

<a href = "add_house" class="btn bg-warning btn-block">Добавить тот адрес который вы вводили</a>

<a href = "/" class="btn bg-warning btn-block">Попробовать еще раз поискать</a>

<a href="https://api.whatsapp.com/send?phone=79789458418" class="btn bg-warning btn-block">Написать админу WhatsApp</a>

';

    redir("/", "20");
}

if (!empty($err)) {

    echo "

$err"; //Функция работает. Текст уведомления. Тип уведомления. Время задержки уведомления на экране.

    include('inc/foot.php');

    exit;
}

$results = $connect->query("SELECT * FROM adress WHERE adress LIKE '$adress' LIMIT 1");

if ($results->num_rows == 1) {
} else {

    echo "</div>";

    redirect("all.php?adress=$adress");

    include "inc/foot.php";

    exit();
}

echo '<form method = "GET" action = "edit.php"  >';

while ($row = $results->fetch_object()) {

    $name = $_COOKIE['user'];

    $user = $connect->query("SELECT * FROM `user` WHERE `name` = '" . $name . "'");

    $usr =  $user->num_rows != 0 ? $user->fetch_array(MYSQLI_ASSOC) : '';

    $status = $usr['viewer'] == 0 ? 'редактирования' : 'просмотра';

    if ($row->region != $usr['region'] and $usr['admin'] == "0") {
    } else {

        // echo "<div class = 'text-center text-muted'>Вы находитесь в режиме: <a href = '?viewer'><b>$status</b></a></div>";
    }
    if (isset($_GET['success'])) {
        alrt("Информация <b>успешно</b> отредактированна", "success", "5");
    }
    echo "<div class = 'text-center text-muted'>Изменялось пользователем <b>$row->editor</b></div>";
?>
<ul class="list-group">
	<li class="list-group-item">
		<div class="section over-hide">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 text-center align-self-center">
						<div class="section text-center py-md-0">



							<?php

			if($usr['admin']){

						?>

							<input class="pricing" type="checkbox" id="pricing" />
							<label for="pricing">
								<span class="block-diff">
									<span style="width: 50%;float:left;vertical-align: middle;"> Редактирование</span>
									<span style="width: 50%;float:right;vertical-align: middle;">Просмотр</span>
								</span>
							</label>

							<?php
						}else{
						if($row->region == $usr['region'] and $usr['viewer']){
								?>

							<input class="pricing" type="checkbox" id="pricing" />
							<label for="pricing">
								<span class="block-diff">
									<span style="width: 50%;float:left;vertical-align: middle;"> Редактирование</span>
									<span style="width: 50%;float:right;vertical-align: middle;">Просмотр</span>
								</span>
							</label>

							<?php
						}
					}
						?>


							<div class="card-3d-wrap mx-auto">
								<div class="card-3d-wrapper">











									<div class="card-front">


										<?php
                $row->complete == 1 ? $complete = "checked" : $complete = "";
										?>
										<div style="text-align: -webkit-center;">
											<div class="onoffswitch">

												<input type="checkbox" name="check" id="myonoffswitch" class="onoffswitch-checkbox" tabindex="0"
													value="1" <?= $complete ?> aria-label="myonoffswitch">

												<label class="onoffswitch-label" for="myonoffswitch">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>

											</div>

											<label for="onoffswitch">Завершен?</label>

										</div>

										<!--Кнопка удаления дома из базы данных--->

										<script type="text/javascript">
										function startdel(i) {

											if (confirm("Точно удалить дом из базы?")) {

												parent.location = 'del.php?adress=<?= h($adress); ?>&id=' + i;

											}

										}
										</script>

										<?php if ($usr['region'] == $row->id || $usr['admin'] == '1') { ?>

										<a href="JavaScript:startdel(<?= $row->id ?>)" class="del_button" aria-label="Удалить">

											<span aria-hidden="true"><img src="img/icon/remove.png" alt="Удалить" width="24px"
													height="24px"></span>

										</a>

										<?php  }

    print '<input name = "id" type="hidden"  value = "' . $row->id . '">';
    out_in("adress", "$adress", "");
    echo'<br>';
    if ($row->oboryda == "Чердак") {

        out_sel("podjezd", "$adress", "Сколько подъездов?");

        echo '<small  class="form-text text-muted">В каком подъезде выход?</small>

<select multiple name="vihod[]" class="form-select mr-sm-2">';

        $vih = $connect->query("SELECT * FROM vihod");

        while ($vihod = $vih->fetch_object()) {

            $sel_vih = $row->vihod == $vihod->name ? 'selected' : '';

            $sel_vih2 = $row->vihod2 == $vihod->name ? 'selected' : '';

            $sel_vih3 = $row->vihod3 == $vihod->name ? 'selected' : '';

            $sel_vih4 = $row->vihod4 == $vihod->name ? 'selected' : '';

            $sel_vih5 = $row->vihod5 == $vihod->name ? 'selected' : '';

            echo "<option $sel_vih $sel_vih2 $sel_vih3 $sel_vih4 $sel_vih5 value='$vihod->name'>$vihod->name</option>";

        }

        echo '</select>';

        out_sel("krisha", "$adress", "Какая крыша?");

        out_in("kluch", "$adress", "У кого ключ от чердака");

        out_sel("lesnica", "$adress", "Есть ли лестница?");

        out_sel("dopzamok", "$adress", "Есть ли доп. замок?");
    }

    if ($row->oboryda == "Подвал") {

        out_sel("podjezd", "$adress", "Сколько подъездов?");

        echo '<small  class="form-text text-muted">В каком подъезде подвал?</small>

<select multiple name="vihod[]" class="form-select mr-sm-2">';

        $vih = $connect->query("SELECT * FROM vihod ");

        while ($vihod = $vih->fetch_object()) {

            $sel_vih = $row->vihod == $vihod->name ? 'selected' : '';

            $sel_vih2 = $row->vihod2 == $vihod->name ? 'selected' : '';

            $sel_vih3 = $row->vihod3 == $vihod->name ? 'selected' : '';

            $sel_vih4 = $row->vihod4 == $vihod->name ? 'selected' : '';

            $sel_vih5 = $row->vihod5 == $vihod->name ? 'selected' : '';

            echo "<option $sel_vih $sel_vih2 $sel_vih3 $sel_vih4 $sel_vih5 value='$vihod->name'>$vihod->name</option>";
        }

        echo '</select>';

        out_in("kluch", "$adress", "У кого ключ от чердака");

        out_sel("dopzamok", "$adress", "Есть ли доп. замок?");
    }

    if ($row->oboryda == "Подъезд") {

        out_sel("podjezd", "$adress", "Сколько подъездов?");

        echo '<small  class="form-text text-muted">В каком подъезде оборудование?</small>

<select multiple name="vihod[]" class="form-select mr-sm-2">';

        $vih = $connect->query("SELECT * FROM vihod ");

        while ($vihod = $vih->fetch_object()) {

            $sel_vih = $row->vihod == $vihod->name ? 'selected' : '';

            $sel_vih2 = $row->vihod2 == $vihod->name ? 'selected' : '';

            $sel_vih3 = $row->vihod3 == $vihod->name ? 'selected' : '';

            $sel_vih4 = $row->vihod4 == $vihod->name ? 'selected' : '';

            $sel_vih5 = $row->vihod5 == $vihod->name ? 'selected' : '';

            echo "<option $sel_vih $sel_vih2 $sel_vih3 $sel_vih4 $sel_vih5 value='$vihod->name'>$vihod->name</option> $sel_vih";
        }

        echo '</select>';

        out_sel("dopzamok", "$adress", "Есть ли доп. замок?");
    }

    if ($row->oboryda == "Фасад") {

        out_sel("podjezd", "$adress", "Сколько подъездов?");
		//out_sel("pitanie", "$adress", "Откуда питание?");
		out_in("pitanie", "$adress", "Где берется питание?");
		out_in("link", "$adress", "Откуда линк?");




    }

    if ($row->oboryda == "Не указанно") {

        echo '<small  class="form-text text-muted">В каком подъезде выход?</small>

<select multiple name="vihod[]" class="form-select mr-sm-2">';

        $vih = $connect->query("SELECT * FROM vihod ");

        while ($vihod = $vih->fetch_object()) {

            $sel_vih = $row->vihod == $vihod->name ? 'selected' : '';

            $sel_vih2 = $row->vihod2 == $vihod->name ? 'selected' : '';

            $sel_vih3 = $row->vihod3 == $vihod->name ? 'selected' : '';

            $sel_vih4 = $row->vihod4 == $vihod->name ? 'selected' : '';

            $sel_vih5 = $row->vihod5 == $vihod->name ? 'selected' : '';

            echo "<option $sel_vih $sel_vih2 $sel_vih3 $sel_vih4 $sel_vih5 value='$vihod->name'>$vihod->name</option>";
        }

        echo '</select>';


        out_sel("podjezd", "$adress", "Сколько подъездов?");

        out_sel("dopzamok", "$adress", "Есть ли доп. замок?");

        out_in("kluch", "$adress", "У кого ключ от чердака");
    }

    if ($usr['admin'] == '1') {

        out_sel("region", "$adress", "Регион");
    } else {

        echo "<input type='hidden' name='region' value='$usr[region]'>";
    }

    out_sel("pon", "$adress", "Технология подключения");

    //out_sel("oboryda", "$adress", "Где оборудование?");

    if ($row->oboryda == "Не указанно") {

        out_sel("oboryda", "$adress", "<b><font color = red>Где оборудование?</font></b>");
    } else {

        out_sel("oboryda", "$adress", "Где оборудование?");
    }

    out_in("pred", "$adress", "Кв. и Ф.И.О председателя");

    out_in("phone", "$adress", "Номер телефона председателя");

    //out_in("text", "$adress", "Для заметок");
		?>
										<small class="form-text text-muted">Для заметок</small>
										<input name="text" type="text" class="form-control" placeholder="Для заметок">
										<?php
echo '<div class="d-grid gap-2">';
echo '<button type="submit" class="btn btn-primary btn-lg">Сохранить изменения</button>';
echo '</div>';

?>
									</div>
									<div class="card-back">
										<table class="table table_stl">
											<tbody>
												<tr>
													<td>Адрес:</td>
													<td><?= $row->adress ?></td>
												</tr><?php if ($row->oboryda == "Чердак") { ?><tr>
													<td>Количество подъездов:</td>
													<td><?= $row->podjezd ?></td>
												</tr>
												<tr>
													<td>В каком подъезде выход:</td>
													<?php $row->vihod = empty($row->vihod) ? '' : $row->vihod . '<br>'; $row->vihod2 = empty($row->vihod2) ? '' : $row->vihod2 . '<br>'; $row->vihod3 = empty($row->vihod3) ? '' : $row->vihod3 . '<br>'; $row->vihod4 = empty($row->vihod4) ? '' : $row->vihod4 . '<br>'; $row->vihod5 = empty($row->vihod5) ? '' : $row->vihod5 . '<br>'; ?>
													<td>
														<?= $row->vihod ?><?= $row->vihod2 ?><?= $row->vihod3 ?><?= $row->vihod4 ?><?= $row->vihod5 ?>
													</td>
												</tr>
												<tr>
													<td>Какая крыша:</td>
													<td><?= $row->krisha ?></td>
												</tr>
												<tr>
													<td>В какой кв. ключ:</td>
													<td><?= $row->kluch ?></td>
												</tr>
												<tr>
													<td>Наличие лестницы:</td>
													<td><?= $row->lesnica ?></td>
												</tr>
												<tr>
													<td>Есть ли доп. замок:</td>
													<td><?= $row->dopzamok ?></td>
												</tr><?php } if ($row->oboryda == "Подвал") { ?><tr>
													<td>Количество подъездов:</td>
													<td><?= $row->podjezd ?></td>
												</tr>
												<tr>
													<td>В каком подъезде выход:</td>
													<?php $row->vihod = empty($row->vihod) ? '' : $row->vihod . '<br>'; $row->vihod2 = empty($row->vihod2) ? '' : $row->vihod2 . '<br>'; $row->vihod3 = empty($row->vihod3) ? '' : $row->vihod3 . '<br>'; $row->vihod4 = empty($row->vihod4) ? '' : $row->vihod4 . '<br>'; $row->vihod5 = empty($row->vihod5) ? '' : $row->vihod5 . '<br>'; ?>
													<td>
														<?= $row->vihod ?><?= $row->vihod2 ?><?= $row->vihod3 ?><?= $row->vihod4 ?><?= $row->vihod5 ?>
													</td>
												</tr>
												<tr>
													<td>В какой кв. ключ:</td>
													<td><?= $row->kluch ?></td>
												</tr>
												<tr>
													<td>Есть ли доп. замок:</td>
													<td><?= $row->dopzamok ?></td>
												</tr><?php } if ($row->oboryda == "Фасад") { ?><tr>
													<td>Количество подъездов:</td>
													<td><?= $row->podjezd ?></td>
												</tr><?php } if ($row->oboryda == "Подъезд") { ?><tr>
													<td>Количество подъездов:</td>
													<td><?= $row->podjezd ?></td>
												</tr>
												<tr>
													<td>В каком подъезде выход:</td>
													<?php $row->vihod = empty($row->vihod) ? '' : $row->vihod . '<br>'; $row->vihod2 = empty($row->vihod2) ? '' : $row->vihod2 . '<br>'; $row->vihod3 = empty($row->vihod3) ? '' : $row->vihod3 . '<br>'; $row->vihod4 = empty($row->vihod4) ? '' : $row->vihod4 . '<br>'; $row->vihod5 = empty($row->vihod5) ? '' : $row->vihod5 . '<br>'; ?>
													<td>
														<?= $row->vihod ?><?= $row->vihod2 ?><?= $row->vihod3 ?><?= $row->vihod4 ?><?= $row->vihod5 ?>
													</td>
												</tr>
												<tr>
													<td>Есть ли доп. замок:</td>
													<td><?= $row->dopzamok ?></td>
												</tr><?php } if ($row->oboryda == "Не указанно") { ?><tr>
													<td>Количество подъездов:</td>
													<td><?= $row->podjezd ?></td>
												</tr>
												<tr>
													<td>В каком подъезде выход:</td>
													<?php $row->vihod = empty($row->vihod) ? '' : $row->vihod . '<br>'; $row->vihod2 = empty($row->vihod2) ? '' : $row->vihod2 . '<br>'; $row->vihod3 = empty($row->vihod3) ? '' : $row->vihod3 . '<br>'; $row->vihod4 = empty($row->vihod4) ? '' : $row->vihod4 . '<br>'; $row->vihod5 = empty($row->vihod5) ? '' : $row->vihod5 . '<br>'; ?>
													<td>
														<?= $row->vihod ?><?= $row->vihod2 ?><?= $row->vihod3 ?><?= $row->vihod4 ?><?= $row->vihod5 ?>
													</td>
												</tr>
												<tr>
													<td>Какая крыша:</td>
													<td><?= $row->krisha ?></td>
												</tr>
												<tr>
													<td>В какой кв. ключ:</td>
													<td><?= $row->kluch ?></td>
												</tr>
												<tr>
													<td>Наличие лестницы:</td>
													<td><?= $row->lesnica ?></td>
												</tr>
												<tr>
													<td>Есть ли доп. замок:</td>
													<td><?= $row->dopzamok ?></td>
												</tr><?php } ?><tr class="text-danger">
													<td>Принадлежность к региону:</td>
													<td><?= $row->region ?></td>
												</tr>
												<tr>
													<td>Тип подключения:</td>
													<td><?= $row->pon ?></td>
												</tr>
												<tr>
													<td>Размещение оборудования:</td>
													<td><?= $row->oboryda ?></td>
												</tr>
												<tr>
													<td>Ф.И.О председателя:</td>
													<td><?= $row->pred ?></td>
												</tr>
												<tr>
													<td>Номер телефона председателя:</td>
													<td><a href="tel:<?= $row->phone ?>"><?= $row->phone ?></a></td>
												</tr>
											</tbody>
										</table>











										<div class="list-group">
											<div class="list-group-item list-group-item-action" style="position: initial;">
												<style>
												.list-group-item-action:hover {
													background-color: transparent;
													color: black;
												}

												.list-group-item-action:active {
													background-color: transparent;
													color: black;
												}
												</style>
												<div class="d-flex w-100 justify-content-between">

													<h5 class="mb-1">Примечания:</h5>
												</div>
												<div class="text-muted" style="height:100px; overflow-x: auto;">
													<?= $row->text ?></div>
											</div>
										</div>
										<?php if($usr['admin'] == 1){?>
										<div class="list-group">
											<div class="list-group-item list-group-item-action" style="position: initial;">

												<div class="d-flex w-100 justify-content-between">

													<h5 class="mb-1">История изменений:</h5>
												</div>
												<div class="text-muted" style="height:100px;overflow-x: auto;">
													<?= $row->history ?></div>
											</div>
										</div>
										<?php
}
									?>



									</div>
	</li>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>













































	</li>

	</main>

	<?php

        include 'inc/foot.php';

        exit();
    }

    if (isset($_GET['success'])) {
        alrt("Информация <b>успешно</b> отредактированна", "success", "5");
    }

    if ($row->oboryda == "Не указанно") {
        alrt("Укажите <b>где размещается оборудование</b> в первую очередь. <br>От этого выбора зависит дальнейшее заполнение.", "danger", "30");
    }

    print '<input name = "id" type="hidden"  value = "' . $row->id . '">';

    print '<li class="list-group-item active">';

    out_in("adress", "$adress", "");

    ?>





	<!--Кнопка удаления дома из базы данных--->

	<script type="text/javascript">
	function startdel(i) {

		if (confirm("Точно удалить дом из базы?")) {

			parent.location = 'del.php?adress=<?= h($adress); ?>&id=' + i;

		}

	}
	</script>

	<?php if ($usr['region'] == $row->id || $usr['admin'] == '1') { ?>

	<a href="JavaScript:startdel(<?= $row->id ?>)" class="del_button" aria-label="Удалить">

		<span aria-hidden="true"><img src="img/icon/remove.png" alt="Удалить" width="24px" height="24px"></span>

	</a>

	<?php  }



    echo '</li>';



echo'</form></ul>';

include 'inc/foot.php';