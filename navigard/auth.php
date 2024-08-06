<?php
include 'inc/head.php';
if (isset($_GET['err'])) {
//ОШИБКА АВТОРИЗАЦИИ
    $error = h(e($_GET['err']));
//alrt("Ошибка $error", "danger", "2");
    ?>
<script type="text/javascript">
alert('Ошибка <?=$error?>')
document.location.replace("/auth");
</script>
    <?php
exit();
}
if (isset($_GET['reg'])) { ?>
<head>
	<title>Регистрация</title>
</head>
<div style="text-align: center;">
	<img src="img/mail.png" width="25%" style="padding: 30px 0 0;" alt="mail">
	<div style="padding: 30px 30px 20px;color: black;font-weight: 500;">
		Введите свою рабочую почту которуя закреплена за вами в базе данных Ардинвест.<br>
	</div>
</div>
<form style="    padding: 20px;" method="GET" action="doreg.php">
	<input type="email" autocomplete="off" id="mail" name="email" class="form-control" required
		placeholder="Введите email">
	<div id="display"></div>
	<div class="d-grid gap-2"><button type="submit" style="margin: 20px 0 0;" class="btn bg-warning btn-lg">Регистрация</button></div>
</form>
<script type="text/javascript" src="searcher_email.js"></script>
</div>
<?php
    include 'inc/foot.php';
    exit();
}
///////////////////////////////////////закончилась регистрация///////////////////////////////////////////////////////////
//////АВТОРИЗАЦИЯ
?>
<head>
	<title>Авторизация</title>
</head>
<li class="list-group-item">
	<form method="POST" action="auth_obr.php">
		<div class="m-3">
			<div style="text-align: center;">Для пользования сервисом авторизуйтесь или зарегистрируйтесь под своей учетной записью</div>
			<br>
			<input name="login" id="exampleInputlogin" type="text" class="form-control" placeholder="Введите логин">
		</div>
		<div class="m-3">
			<input name="pass" type="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль">
		</div>
		<hr>
		<div class="d-grid gap-2">
			<button type="submit" class="btn btn-warning btn-lg ">Вход</button>
		</div>
	</form> <br>
	<div class="d-grid gap-2">
		<a class="btn btn-danger btn-lg" href="auth.php?reg">Новый пользователь?</a>
	</div>
	</div>
	<?php ///низ сайта
    include 'inc/foot.php';
    ?>