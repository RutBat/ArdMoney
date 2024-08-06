<?php
session_start();
include 'inc/head.php';
if ($_COOKIE['first_auth'] != "new") {
	setcookie('first_auth', "new", time() + 60 * 60 * 24 * 3650, '/');
	red_index('hello.php');
}
if (isset($_GET['err'])) {
	//ОШИБКА АВТОРИЗАЦИИ
	$error = h(e($_GET['err']));
	//alrt("Ошибка $error", "danger", "2");
?>
	<script type="text/javascript">
		alert('Ошибка <?= $error ?>')
		document.location.replace("auth.php");
	</script>
<?php
	exit();
}
if (isset($_GET['reg'])) { ?>

	<head>
		<title>Регистрация</title>
	</head>
	</nav>
	<div style="text-align: center;">
		<img src="img/mail.png" width="25%" style="padding: 30px 0 0;" alt="mail">
		<div style="padding: 30px 30px 20px;color: black;font-weight: 500;">
			Введите свою рабочую почту которуя закреплена за вами в базе данных Ардинвест.<br>
			Это нужно что бы пользоватся могли только сотрудники СКС.<br>
			Если возникли проблемы то напишите администратору в <a href="https://rutbat.t.me">Telegram</a>.
		</div>
	</div>
	<form style="padding: 20px;" method="GET" action="doreg.php">
		<label for="mail"></label><input type="email" autocomplete="off" id="mail" name="email" class="form-control" required placeholder="Введите email">
		<div id="display"></div>
		<div class="d-grid gap-2">
			<button type="submit" style="margin: 20px 0 0;" class="btn bg-warning btn-lg">Регистрация</button>
		</div>
	</form>
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

		<p class="fs-4 p-4 container text-muted fw-bold">
			Для пользования сервисом
			<span style="color: green;">авторизуйтесь</span> или <span style="color: red;">зарегистрируйтесь</span> под своей
			учетной записью
		</p>

		<div class="m-3">
			<label for="exampleInputlogin"></label><input name="login" id="exampleInputlogin" type="text" class="form-control" placeholder="Введите логин">
		</div>
		<div class="m-3">
			<label for="exampleInputPassword1"></label><input name="pass" type="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль">
		</div>
		<hr>
		<div class="d-grid gap-2">
			<button type="submit" class="btn btn-warning btn-lg ">Вход</button>
		</div>
	</form>
	<br>
	<div class="d-grid gap-2">
		<a class="btn btn-danger btn-lg" href="auth.php?reg">Новый пользователь?</a>
	</div>
	</div>
	<?php ///низ сайта
	include 'inc/foot.php';
	?>