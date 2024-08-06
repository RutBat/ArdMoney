<?php
include("inc/head.php");
access();
AutorizeProtect();
global $connect;
global $usr;
echo '<div class="contadiner">';
$email   = $_GET['email'];
$region   = $_GET['region'];
$fio = $_GET['fio'];
if (empty($email)) {
	echo 'Введите почту';
	exit;
}
if (empty($region)) {
	echo 'Введите регион';
	exit;
}
if (empty($fio)) {
	echo 'Введите фамилию и инициалы';
	exit;
}

$user = $usr['name'];

$sql = "INSERT INTO user (email, fio, region)
			VALUES (
			'$email',
			'$fio',
			'$region')";
if ($connect->query($sql) === true) {
} else {
	echo $connect->error;
}



?>
<meta http-equiv="refresh" content="0;URL='adm_setting.php?complete_reg'">
</div>
<?php
include('inc/foot.php');
