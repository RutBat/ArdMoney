<?php
include "inc/head.php";
AutorizeProtect();
access();
global $connect;
global $usr;
$id = e(h($_GET['id']));
$user123 = $connect->query("SELECT * FROM `user` WHERE `id` = '" . $id . "'");
if ($user123->num_rows != 0) {
	$usr_del = $user123->fetch_array(MYSQLI_ASSOC);
} else {
	$usr_del = "";
}
$email_del = $usr_del['email'];
$fio_del = $usr_del['fio'];
$date = date("d.m.Y H:i:s");
$user = $usr['fio'];
$text = 'удалил пользователя ';
$log = "Пользователь $user $text $fio_del / $email_del";
$zap = "INSERT INTO log (kogda, log)
		VALUES (
		'$date',
		'$log'
		)";
if ($connect->query($zap) === false) {
	echo $connect->error;
}
$results = $connect->query("SELECT * FROM user WHERE id = '$id'");
$sql = " DELETE FROM user WHERE id = '$id'";
if (mysqli_query($connect, $sql)) { ?>
<?php
	red_index("adm_setting?del_ok");
	exit;
	echo '<br><br><br>';
} else {
	echo "Error deleting record: " . mysqli_error($connect);
}
mysqli_close($connect);
include 'inc/foot.php';
