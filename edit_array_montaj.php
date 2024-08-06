<?php
include "inc/head.php";
AutorizeProtect();
access();
global $connect;
global $usr;
$id_vid_rabot = h($_GET['id']);
$id_montaj = $_GET['mon_id'];
$count = h($_GET['count']);
$name = h($_GET['name']);
$new_name = $_GET['new_name'];
$status_baza = h($_GET['status_baza']);
if ($new_name == $name) {
	$new_name = $name;
}
if (isset($_GET['count'])) {
	edit_montaj_vidrabot("$id_vid_rabot", "$name", "$new_name", "$count");
	edit_montaj_summa("$id_montaj", "2", "2");
	$str = $id_montaj;
	$encodedStr = base64_encode($str);
	red_index("result.php?vid_id=$encodedStr");
}
$arr = $connect->query("SELECT * FROM `array_montaj` WHERE `id` = '" . $id_vid_rabot . "' limit 1");
if ($arr->num_rows != 0) $arr_vidrabot = $arr->fetch_array(MYSQLI_ASSOC);
$arr_vidrabot['name'];
?>
<div class="text-center alert alert-secondary">
	<?= $arr_vidrabot['name'] ?>
</div>
<form action="edit_array_montaj.php" class="row g-3" style="margin:10px;">
	<?
	if ($arr_vidrabot['name'] == "Другое") {
	?>
		<input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Что делали:">
		<input class="form-control form-control" type="text" name="new_name" placeholder="<?= $arr_vidrabot['name'] ?>" value="<?= $arr_vidrabot['name'] ?>" aria-label="Количество">
	<?
	} else {
	?>
		<input name="new_name" type="hidden" value="<?= $arr_vidrabot['name'] ?>">
	<?
	}
	?>
	<input name="mon_id" type="hidden" value="<?= $id_montaj
												?>">
	<input name="id" type="hidden" value="<?= $id_vid_rabot
											?>">
	<input name="name" type="hidden" value="<?= $name
											?>">
	<div class="col-auto">
		<input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Количество:">
	</div>
	<div class="col-auto">
		<input name="count" class="form-control form-control" type="text" name="count" placeholder="<?= $arr_vidrabot['count'] ?>" value="<?= $arr_vidrabot['count'] ?>" aria-label="Количество">
	</div>
	<div class="d-grid">
		<button class="btn btn-primary" type="success">Редактировать</button>
	</div>
</form>
<?
include('inc/foot.php');
