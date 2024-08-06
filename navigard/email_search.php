<?php
include "inc/db.php";
global $connect;
global $usr;
if (isset($_POST['search'])) {

$str = $_POST['search'];
$pattern = "/@/i";
if (preg_match($pattern, $str)) {
$Name = htmlspecialchars(htmlentities($_POST['search']));
$Query = "SELECT * FROM user WHERE email LIKE '$Name%' LIMIT 1";
$ExecQuery = mysqli_query($connect, $Query);
$num_rows = mysqli_num_rows($ExecQuery);
// Создаем список для отображения результатов
echo '<ul class="list-group">';
	?>
<style>
.small {
	padding: 0.35rem 0 0.25rem 0.75rem;
}
</style>
<?php
	//Перебираем результаты из базы данных
	while ($Result = mysqli_fetch_array($ExecQuery)) {
?>

<li class="list-group-item small" onclick='fill("<?php echo $Result['email']; ?>")'>
	<a>
		<?php echo $Result['email']; ?>
	</a>
</li>

        <?php

		if(empty($Result['reger'])){

		echo"Даную почту можно использовать";
	}else{
		echo"Данная почта уже зарегистрированна, <a class='text-success' href='/auth'>авторизуйтесь</a>";
	}

	}
	if($num_rows == 0){

		echo"Даной почте нельзя регистрироватся - свяжитесь с <a class='text-danger' href='https://api.whatsapp.com/send?phone=79789458418'>администрацией</a> ";
	}
}


}
	?>
</ul>