<?php
session_start();
include 'inc/head.php';
global $connect;
global $usr;
?>

<head>

	<title>Регистрация</title>

</head>
<?php






















$Email = htmlspecialchars(htmlentities($_GET['email']));
$_COOKIE['email'] = $Email;
$Query = "SELECT * FROM user WHERE email LIKE '$Email' LIMIT 1";
$ExecQuery = mysqli_query($connect, $Query);
$num_rows = mysqli_num_rows($ExecQuery);
// Создаем список для отображения результатов


	//Перебираем результаты из базы данных
	while ($Result = mysqli_fetch_array($ExecQuery)) {


		if(empty($Result['reger'])){

		alrt("Проверка e-mail успешно пройдена", "success", "100000000");


		?>
            <div style="text-align: center;">Здравствуйте <b><?=$Result['fio']?> </b><br>Для удобного доступа придумайте логин и пароль.<br></div>
	<?php

	}else{
		echo"Данная почта уже зарегистрированна, <a class='text-success' href='/auth'>авторизуйтесь</a>";
	exit;
}


	}
	if($num_rows == 0){

		echo"Даной почте нельзя регистрироватся - свяжитесь с <a class='text-danger' href='https://api.whatsapp.com/send?phone=79789458418'>администрацией</a> ";
	exit;
}



?>






	<form method="GET" action="reg.php">

		<div class="form-row">

			<div class="col-md-8 col-sm-12  mx-auto">

				<li class="list-group-item">

					<input type="text" name="login" class="form-control" required title="Введите от 4 символов"
						placeholder="Логин">

					<input type="text" name="pass" class="form-control" required title="Введите от 4 символов"
						placeholder="Пароль">
					<input type="hidden" name="email" value="<?=$Email?>">

					<hr>
					<div class="d-grid gap-2">

						<button type="submit" class="btn btn-warning btn-lg ">Регистрация</button>
					</div>

				</li>

			</div>

		</div>

	</form>

	</div>

	<?php

    include 'inc/foot.php';

    exit();