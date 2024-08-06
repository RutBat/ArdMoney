<?php
include "inc/head.php";
AutorizeProtect();
global $connect;
global $usr;
$id = e(h($_GET['id']));
$adress = e(h($_GET['adress']));
if(empty($adress)){
	$value = '&id=ok';
}else{
	$value = '?id=ok';
}
$date = date("d.m.Y H:i:s");
$user = $usr['name'];
$region = $usr['region'];
$text = 'удалил дом с id';
$dom = '$id';
$log = "Пользователь $user $text $id";
$zap = "INSERT INTO log (kogda, log)
		VALUES (
		'$date',
		'$log'
		)";
		if ($connect->query($zap) === false) {
		echo $connect->error;	}
$results = $connect->query("SELECT * FROM adress WHERE id = '$id'");
$sql = " DELETE FROM adress WHERE id = '$id'";
if (mysqli_query($connect, $sql)) { ?>
<?php
$whereareyoufrom = $_SERVER['HTTP_REFERER'];
red_index("all?id=ok");
exit;
echo '<br><br><br>';
} else {echo "Error deleting record: " . mysqli_error($connect);}
mysqli_close($connect);
include 'inc/foot.php';