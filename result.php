<?php
session_start();
$url = $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];

include("inc/function.php"); // Тут висят все функции сайта.
echo '<!doctype html><html lang="ru">';
include("inc/style.php"); // тег head в котором указываются все стили сайта
echo '<body style = "background: #ffffff url(img/background.webp) repeat;">';
echo '<div class="container-sm">';
AutorizeProtect();
access();
global $connect;
global $usr;
global $used_router;
$encodedStr = $_GET["vid_id"];
$id = base64_decode($encodedStr);
$montaj = $connect->query("SELECT * FROM `montaj` WHERE `id` = '" . $id . "' limit 1");
if ($montaj->num_rows != 0) $mon = $montaj->fetch_array(MYSQLI_ASSOC);
if ($url == "/result.php") {
	include("inc/navbar_result.php"); //Навигационный бар

} else {
	include("inc/navbar.php"); //Навигационный бар

}
?>

<main role="main">
	<div style="min-height: calc(100vh - 9rem);padding: 0 0;    background: #fff;
" class="jumbotron">
		<div class="col-md-12 col-sm-12  mx-auto">
			<main role="main">
				<div style="padding: 0 0;" class="jumbotron">
					<div class="col-md-12 col-sm-12  mx-auto">
						<div class="section over-hide">
							<div class="row justify-content-center">
								<div class="col-12 text-center align-self-center">
									<?php ava($encodedStr, $mon); ?>


									<head>
										<title>
											<?= $mon['adress'] ?>
										</title>
									</head>

									<link rel="stylesheet" href="css/fix.css">
									<div class="section text-center py-md-0">
										<span style="background: #45f977ab; display:block;">
											<?= $mon['date'] ?>
											<b>
												<rut id="mon_adress"><?= $mon['adress'] ?></rut>
											</b>
											<a id="image"><i class="bi bi-info-circle"></i></a>
											<br>
											<rut id="mon_adress_text"><?= $mon['text'] ?></rut>
											<img src="img/edit.png" id="image_text" alt="Картинка" width="16px">
										</span>

										<form id="update_form" style="display:none;">
											<label for="new_adress">Новый адрес:</label>
											<input type="text" id="new_adress" name="new_adress" value="<?= $mon['adress'] ?>">
											<input type="submit" value="Сохранить">
										</form>

										<form id="update_form_text" style="display:none;">
											<label for="new_adress_text">Новое описание:</label>
											<input type="text" id="new_adress_text" name="new_adress_text" value="<?= $mon['text'] ?>">
											<input type="submit" value="Сохранить">
										</form>

										<script>
											var image = document.getElementById("image");
											var block = document.getElementById("update_form");
											image.addEventListener("click", function() {
												if (block.style.display === "none") {
													block.style.display = "block";
												} else {
													block.style.display = "none";
												}
											});
											$(function() {
												$('#update_form').submit(function(event) {
													event.preventDefault();
													var new_adress = $('#new_adress').val();
													$.ajax({
														url: 'adress_update.php',
														type: 'POST',
														data: {
															id: <?= $mon['id']; ?>,
															adress: new_adress
														},
														success: function(data) {
															// Обновляем значение в блоке на странице
															$('#update_form').hide();
															$('#mon_adress').text(new_adress);
														}
													});
												});
											});

											var image_text = document.getElementById("image_text");
											var block_text = document.getElementById("update_form_text");
											image_text.addEventListener("click", function() {
												if (block_text.style.display === "none") {
													block_text.style.display = "block";
												} else {
													block_text.style.display = "none";
												}
											});
											$(function() {
												$('#update_form_text').submit(function(event) {
													event.preventDefault();
													var new_text = $('#new_adress_text').val();
													$.ajax({
														url: 'text_update.php',
														type: 'POST',
														data: {
															id: <?= $mon['id']; ?>,
															text: new_text // Исправлено на 'text'
														},
														success: function(data) {
															// Обновляем значение в блоке на странице
															$('#update_form_text').hide();
															$('#mon_adress_text').text(new_text); // Исправлено на '#mon_adress'
														}
													});
												});
											});
										</script>

										<?
										$tech1 = $mon['technik1'];
										$tech2 = $mon['technik2'];
										$tech3 = $mon['technik3'];
										$tech4 = $mon['technik4'];
										$tech5 = $mon['technik5'];
										$tech6 = $mon['technik6'];
										$tech7 = $mon['technik7'];
										$tech8 = $mon['technik8'];
										$ebat_code = 0;
										for ($i = 1; $i <= 8; $i++) {
											$tech = "tech$i";
											if (!empty(${$tech})) {
												$ebat_code = $i;
											}
										}
										?>
										<ol class="list-group list-group-numbered" style="font-size: small;">
											<?
											$sql = "SELECT * FROM `array_montaj` WHERE mon_id = '$id'";
											$results = mysqli_query($connect, $sql);
											while ($vid_rabot = mysqli_fetch_array($results)) {
												if ($vid_rabot['price'] == 0) {
													$bg_acent = "background: #c8e4f58c;";
												} else {
													$bg_acent = "";
												}
											?>
												<li class="list-group-item d-flex justify-content-between align-items-start" style="text-align: left;<?= $bg_acent
																																						?>">
													<div class="ms-2 me-auto">
														<div class="fw-normal">
															<a style="color:#000;" href="edit_array_montaj.php?id=<?= $vid_rabot['id'] ?>&mon_id=<?= $id ?>&name=<?= $vid_rabot['name'] ?>&status_baza=<?= $vid_rabot['status_baza'] ?> ">
																<?= $vid_rabot['name'] ?>
																<?
																if ($vid_rabot['name'] == "Переработка вечер с 18 до 22") {
																	$vid_rabot['count'] = $vid_rabot['count'] / $ebat_code;
																	if ($vid_rabot['count'] == 1) {
																		echo "( $vid_rabot[count] час / $ebat_code чел.)";
																	} else {
																		echo "( $vid_rabot[count] часа / $ebat_code чел.)";
																	}
																} else {
																	if ($vid_rabot['count'] == 1) {
																	} else {
																		if ($vid_rabot['price'] == 0) {
																			echo "( $vid_rabot[count] метров)";
																		} else {
																			echo "( $vid_rabot[count] едениц)";
																		}
																	}
																}
																?>
															</a>
														</div>
														<?
														if ($vid_rabot['name'] == "Другое") {
														?>
															<span class="text-muted fw-light" style="font-size: small;"><?= $vid_rabot['text'] ?></span>
														<?
														}
														?>
													</div>
													<?
													if ($vid_rabot['price'] != 0) {
													?>
														<span class="badge bg-primary rounded-pill"><?= $vid_rabot['price'] ?>р.</span>
													<?
													}

													$tech1 = $mon['technik1'];
													$tech2 = $mon['technik2'];
													$tech3 = $mon['technik3'];
													$tech4 = $mon['technik4'];
													$tech5 = $mon['technik5'];
													$tech6 = $mon['technik6'];
													$tech7 = $mon['technik7'];
													$tech8 = $mon['technik8'];
													?>
													<a href="edit_mon.php?delete=<?= $vid_rabot['id'] ?>&mon_id=<?= $id ?>&technik1=<?= $tech1 ?>&technik2=<?= $tech2 ?>&technik3=<?= $tech3 ?>&technik4=<?= $tech4 ?>&technik5=<?= $tech5 ?>&technik6=<?= $tech6 ?>&technik7=<?= $tech7 ?>&technik8=<?= $tech8 ?>"><span class="badge bg-danger rounded-pill">X</span></a>
												</li>
											<?
											}
											?>
											<span style="background: #ffffff;">
												<?
												$used_material = "SELECT * FROM used_material WHERE id_montaj = $mon[id]";
												$um = mysqli_query($connect, $used_material);
												$num_results = mysqli_num_rows($um);
												if ($num_results > 0) {
													echo ' Материалы: <br>';
													while ($materials = mysqli_fetch_array($um)) {
														if ($materials['count'] > 4) {
															$chego = "м.";
														} else {
															$chego = "шт.";
														}
														echo "<a style = 'color: black; text-decoration: underline;' href = 'edit_mon.php?material_delete=$materials[id]&mon_id=$mon[id]&status=$mon[status]&status_baza=$mon[status_baza]&technik1=$tech1&technik2=$tech2&technik3=$tech3&technik4=$tech4&technik5=$tech5&technik6=$tech6&technik7=$tech7&technik8=$tech8' >$materials[name]  <b style = 'color:red;' >$materials[count] $chego </b><br></a>";
														$sql_router = "SELECT * FROM `used_router` WHERE `technik` = '" . $usr['fio'] . "'";
														$used_router_result = mysqli_query($connect, $sql_router);
														while ($used_router = mysqli_fetch_array($used_router_result)) {
															if ($materials['name'] == $used_router['router']) {
																echo "<a style = 'color: black; text-decoration: underline;' href = 'router_spisat.php?router=$materials[name]&adress=$mon[adress]&technik=$usr[fio]&refer=$encodedStr' >На тебе числится <span style = 'color:red;' >$materials[name]</span>, списать?</a> <br>";
															}
														}
													}
												}
												echo "Сумма:<span style='color: green;font-weight: bold;'>$mon[summa]₽ </span>";
												echo "Каждому:<span style='color: green;font-weight: bold;'>$mon[kajdomu]₽</span>";
												echo "<br>";
												$ebat_code = 0;
												$who = "";
												for ($i = 1; $i <= 8; $i++) {
													$tech = "tech$i";
													if (!empty(${$tech})) {
														$ebat_code = $i;
														$who .= $mon["technik$i"] . ",";
													}
												}
												$who = rtrim($who, ",");
												echo "Делали: $who ";
												echo '<a id="image_tech"><i class="bi bi-arrow-left-right"></i></a>';
												?>


												<br><br>

												<script>
													$(document).ready(function() {
														$("#image_tech").click(function() {
															$("#dropdown").toggle(); // Переключаем видимость выпадающего списка
														});
													});
												</script>

											</span>
											<form method="GET" action="edit_mon.php" style="background: white;">


												<div id="dropdown" style="display: none;">
													<?
													$sql = "SELECT * FROM `user` WHERE `region` = '" . $usr['region'] . "' ORDER BY `brigada` ";
													$res_data = mysqli_query($connect, $sql);
													while ($tech = mysqli_fetch_array($res_data)) {
														if ($tech1 == $tech['fio']) {
															$check = "checked";
														} elseif ($tech2 == $tech['fio']) {
															$check = "checked";
														} elseif ($tech3 == $tech['fio']) {
															$check = "checked";
														} elseif ($tech4 == $tech['fio']) {
															$check = "checked";
														} elseif ($tech5 == $tech['fio']) {
															$check = "checked";
														} elseif ($tech6 == $tech['fio']) {
															$check = "checked";
														} elseif ($tech7 == $tech['fio']) {
															$check = "checked";
														} elseif ($tech8 == $tech['fio']) {
															$check = "checked";
														} else {
															$check = "";
														}

													?>
														<div class="form-check">
															<div id="checklist" class="form-check">
																<input <?= $check ?> type="checkbox" value="<?= $tech['fio'] ?>" name="technik[]" id="flexCheckDefault<?= $tech['id'] ?>">
																<label for="flexCheckDefault<?= $tech['id'] ?>"> <?= $tech['fio'] ?></label>
															</div>
														</div>
													<?
													}
													?>
												</div>
												<?
												$status = $mon['status'] == "1" ? "checked" : "";
												$dogovor = $mon['dogovor'] == "1" ? "checked" : "";
												$if_baza = $mon['status_baza'] == "1" ? "#eef945ab" : "white";
												$status_baza = $mon['status_baza'] == "1" ? "checked" : "";
												$stat = $mon['status'] == "1" ? "checked" : "";
												$stat_baza = $mon['status_baza'] == "1" ? "checked" : "";
												$dogovor = $mon['dogovor'] == "1" ? "checked" : "";
												?>
												<div class="container" style="margin-top: 1rem;">
													<div class="row">
														<div class="col">
															<label class="form-check-label" for="dogovor">Нет договора</label>
														</div>
														<div class="col">
															<label class="form-check-label" for="stat">Подтвердили</label>
														</div>
														<div class="col">
															<?
															if ($stat != 1) {
															?>
																<label class="form-check-label" for="stat_baza">В базе</label>
															<?
															}
															?>
														</div>
													</div>
												</div>
												<div class="container">
													<div class="row">
														<div class="col">
															<div style="display:block;background: <?= $bg ?>;text-align: left;padding: 5px 25% 0px;">
																<div class="form-check form-switch" style="    display: inline-block;">
																	<input name="dogovor" class="dogovor form-check-input" value="" type="checkbox" id="dogovor" data-ajax-handler data-ajaxname="dogovor" data-mon-id="<?= $id ?>" data-server-script="update_dogovor.php" <?= $dogovor ?>>
																</div>
															</div>
														</div>
														<div class="col">
															<div style="display:block;background: <?= $bg ?>;text-align: left;padding: 5px 25% 0px;">
																<div class="form-check form-switch" style="    display: inline-block;">
																	<input name="status" class="status form-check-input" type="checkbox" id="stat" data-ajax-handler data-mon-id="<?= $id ?>" data-ajaxname="stat" data-mon-dat="<?= $mon['date'] ?>" data-server-script="update_status.php" <?= $stat ?>>
																</div>
															</div>
														</div>
														<div class="col">
															<?
															if (!$stat == 1) {
															?>
																<div style="display:block;background: <?= $bg ?>;text-align: left;padding: 5px 25% 0px;">
																	<div class="form-check form-switch" style="    display: inline-block;">
																		<input name="status_baza" class="status_baza form-check-input" type="checkbox" id="stat_baza" data-ajax-handler data-mon-id="<?= $id ?>" data-ajaxname="stat_baza" data-server-script="update_status_baza.php" <?= $stat_baza ?>>
																	</div>
																</div>
															<?
															}
															?>
														</div>
													</div>
												</div>
												<script src="js/checkbox_result.js"></script>

												<?
												$visible = (!empty($status)) ? "display:none;" : "display:block;";
												?>
												<div class="row g-3">
													<div class="col-9" style="width: 74%;">
														<select class="selectpicker form-control dropup" data-dropup-auto="false" style="    background: white;" data-width="100%" data-container="body" title="Материалы" data-hide-disabled="true" data-width="auto" data-live-search="true" name='material' data-size="5">
															<?
															$sql = "SELECT * FROM `material` ORDER BY `name`";
															$results = mysqli_query($connect, $sql);
															while ($material = mysqli_fetch_array($results)) {
															?>
																<option style="color:<?= $material['color'] ?>;font-size: 11pt;" value='<?= $material['name'] ?>'>
																	<?= $material["name"] ?></option>
															<?
															}
															?>
														</select>
													</div>
													<div class="col-3 block">
														<input name="material_count" class="form-control sub-form-control" style="height:35px;" type="text" placeholder="Количество" aria-label="Количество">
													</div>
												</div>
												<hr>
												<small class='form-text '>Добавить вид работ и количество</small>
												<style>
													.g-3,
													.gy-3 {
														background: #fff;
													}
												</style>
												<input name="mon_id" type="hidden" value="<?= $id ?>">
												<input name="summa" type="hidden" value="<?= $row_price_test ?>">
												<input name="kajdomu" type="hidden" value="<?= $kajdomu ?>">

												<style>
													.dropdown-item.active,
													.dropdown-item:active {
														background-color: #40fd0d26;
													}
												</style>
												<?
												vid_rabot_main("vid_rabot1", "count1");
												vid_rabot_main("vid_rabot2", "count2");
												vid_rabot_main("vid_rabot3", "count3");
												vid_rabot_submain("vid_rabot4", "count4");
												?>
												<div data-role="footer">
													<div class="d-grid gap-2">
														<button type="submit" class="btn btn-success btn-lg">Отправить данные</button>
													</div>
												</div>
									</div>
									</ol>
								</div>
							</div>
						</div>
			</main>
		</div>
	</div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
	<script src="js/bootstrap-select.js"></script>
	<script>
		function showSingleDiv(selector) {
			const prevBlockEl = document.querySelector('.single.active'),
				currBlockEl = document.querySelector(selector);
			if (!currBlockEl || prevBlockEl === currBlockEl) return;
			prevBlockEl && prevBlockEl.classList.remove('active');
			currBlockEl.classList.add('active');
		}
	</script>
	<br>
	<?php
	include 'inc/foot.php';
