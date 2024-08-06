<?php
include("inc/head.php");
access();
AutorizeProtect();
global $connect;
global $usr;
echo '<div class="contadiner">';
$adress   = h($_GET['adress'], ENT_QUOTES, "utf-8");
$region   = $_GET['region'];
$technik1 = $_GET['technik']['0'];
$technik2 = $_GET['technik']['1'];
$technik3 = $_GET['technik']['2'];
$technik4 = $_GET['technik']['3'];
$technik5 = $_GET['technik']['4'];
$technik6 = $_GET['technik']['5'];
$technik7 = $_GET['technik']['6'];
$technik8 = $_GET['technik']['7'];
$text     = h($_GET['text'], ENT_QUOTES, "utf-8");
$date     = date("Y.m.d");
$dogovor    = 0;
if (empty($adress)) {
	echo 'Введите адрес монтажа';
	exit;
}
$user = $usr['name'];

$sql = "INSERT INTO montaj (adress, technik1, technik2, technik3, technik4, technik5, technik6, technik7, technik8, text, region, date, dogovor)
			VALUES (
			'$adress',
			'$technik1',
			'$technik2',
			'$technik3',
			'$technik4',
			'$technik5',
            '$technik6',
            '$technik7',
            '$technik8',
			'$text',
            '$region',
			'$date',
            '$dogovor'
			)";
if ($connect->query($sql) === true) {
} else {
	echo $connect->error;
}
$montaj = $connect->query("SELECT * FROM `montaj` ORDER BY id DESC limit 1");
if ($montaj->num_rows != 0)
	$mon = $montaj->fetch_array(MYSQLI_ASSOC);
$str = $mon['id'];
$id = base64_encode($str);



?>
<meta http-equiv="refresh" content="0;URL='result.php?vid_id=<?= $id ?>'">
</div>
<?php
include('inc/foot.php');
