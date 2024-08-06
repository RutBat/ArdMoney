<?php
include "inc/head.php";
access();
AutorizeProtect();
global $connect;
global $usr;
if (isset($_GET['success'])) {
	alrt("Пользователь $_GET[id] отредактирован", "success", "100000000");
}
if (isset($_GET['complete_reg'])) {
	alrt("Пользователь добавлен", "success", "100000000");
}
if (isset($_GET['del_ok'])) {
	alrt("Пользователь удалён", "success", "100000000");
}
///////проверка на админа///////
$admin = $usr['admin'];
if ($admin == 0) {
?>
	<script type="text/javascript">
		document.location.replace("/");
	</script>
<?php
}
//////////////////////////////
?>

<head>
	<title>Админ - Панель</title>
</head>
<ul class="list-group">
	<li class="list-group-item">
		<h5 class="mb-1">Управление пользователями</h5>
		<?php
		if ($usr['admin'] == 1) {


			if (isset($_GET['add_user'])) {

		?>
				<form method="GET" action="add_user.php">
					<div class="list-group-item  justify-content-between align-items-center" style="font-family: system-ui;">
						<div class="mb-3" style="padding: 10px 10px 0px;">
							<p class="fs-6 text-muted fw-bold">
								Укажи почту сотрудника
							</p><br>
							<div style="
    display: block;
    padding: 10px;
    margin: auto;
    width: 100%;">
								<input autofocus list="provlist" type="email" name="email" class="form-control" required title="Введите от 4 символов" placeholder="Введите почту">
							</div>

							<div class="mb-3" style="padding: 1rem 0rem 0rem;">
								<label for="exampleFormControlTextarea1" class="form-label">

									<p class="fs-6 text-muted fw-bold">
										Фамилия и инициалы </p>
									<div style="
    display: block;
    padding: 10px;
    margin: auto;
    width: 100%;">
										<input autofocus list="provlist" type="text" name="fio" class="form-control" required title="Введите от 4 символов" placeholder="Иванов И.И.">
									</div>
								</label>
							</div>
							<br>


							<label for="exampleFormControlTextarea1" class="form-label">

								<p class="fs-6 text-muted fw-bold">
									Регион - <?= $usr['region'] ?> </p>
								<div style="
    display: block;
    padding: 10px;
    margin: auto;
    width: 100%;">

									<?
									if ($usr['name'] == "RutBat") {
									?>
										<input list="provlist" type="text" name="region" class="form-control" required title="Введите от 4 символов" value="<?= $usr['region'] ?>" placeholder="<?= $usr['region'] ?>">

									<?
									} else {
									?>
										<input readonly list="provlist" type="text" name="region" class="form-control" required title="Введите от 4 символов" value="<?= $usr['region'] ?>" placeholder="<?= $usr['region'] ?>">

									<?
									}
									?>
								</div>
							</label>
						</div>
						<br>

						<div data-role="footer">
							<div class="d-grid gap-2 ">
								<button type="submit" class="btn btn-lg" style="background: #445e3b;
    border-radius: 0px;
    border: 2px solid #2c3c26d1;color:#fff">Добавить</button>
							</div>
						</div>
					</div>
					</div>
				</form>

				<?



				exit;
			}






























			//Редактирование пользователя//
			if (!empty($_GET['edit'])) {
				echo '<form action= "edit_user_obr.php" method = "GET">';
				echo '<div class="input-group mb-3">';
				echo '<table>';
				$id_user = $_GET['edit'];
				$sql = "SELECT * FROM user WHERE id = $id_user ";
				$res_data = mysqli_query($connect, $sql);
				while ($row = mysqli_fetch_array($res_data)) {
					$name = trim($row['name']);
					$fio = trim($row['fio']);
					$email = trim($row['email']);
					$admin = trim($row['admin']);
					$id = trim($row['id']);
					$region_user = trim($row['region']);
					$id = $row['id'];
					$admin = $row['admin'];
					$access_date = $row['access_date'];
				?>
					<tr>
						<td>
							<small class="text-danger form-text">Смена пароля производится персонально, через администратора приложения:
								<b>Ершова
									Н.Н.</b><br>Пароль нельзя <b>узнать</b>, можно только <b>сменить</b> на новый!</small><br>
							<small class="text-mute form-text">Имя</small>
							<div class="input-group mb-3">
								<input type="hidden" name="id" value="<?= $id ?>">
								<input type="text" name="name" class="form-control" placeholder="Имя" value="<?= $name ?>">
							</div>
							<small class="text-mute form-text">Почта</small>
							<div class="input-group mb-3">
								<input type="text" name="email" class="form-control" placeholder="Почта" value="<?= $email ?>">
							</div>
							<?
							if ($admin == 1) {
								$checked = "checked";
								$admin = 1;
							} else {
								$checked = "";
								$admin = 0;
							}
							// $cd = date('y-m-d');
							// $ad = $access_date;
							// $cd = strtotime($cd);
							// $ad = strtotime($ad);
							// if($ad < $cd){
							// $acs_sts = 0;
							// }else{
							// 	$acs_sts = 1;
							// }
							if (isset($_GET['podpiska']) and $usr['name'] == 'RutBat') {
								$id = $_GET['edit'];
								$month_podpiska = $_GET['podpiska'];
								$today = date("Y-m-d");
								$time = strtotime($today);
								$final = date("Y-m-d", strtotime("+$month_podpiska month", $time));
								$sql = "UPDATE user SET
access_date = '$final'
WHERE id = '$id'";
								if ($connect->query($sql) === true) {
									red_index("/adm_setting.php?edit=$id");
									exit;
								} else {
									echo "Ошибка: " . $sql . "<br>" . $connect->error;
								}
							}
							?>
							Подписка до <?= $access_date ?> <br>
							<?php
							$sum = 0;
							for ($i = 1; $i <= 12; $i++) {
							?>
								<a style="margin-bottom: 3px;" class="btn btn-primary btn-sm" href="?edit=<?= $id_user ?>&podpiska=<?= $i ?>" role="button">Продлить подписку на <?= $i ?> месяц</a><br>
							<?
							}
							?>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" name="admin" id="flexSwitchCheckChecked" <?= $checked ?>>
								<label class="form-check-label" for="flexSwitchCheckChecked">Админ права:</label>
							</div>
						</td>
					</tr>
				<?php
				}
				?>
				</table>
				</div>
				<div class="d-grid gap-2">
					<button type="submit" class="btn bg-warning">Применить изменения</button>
				</div>
				</form>
			<?php
				exit;
			}
			echo '<div
		class="input-group"
		style ="
		position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
    justify-content: space-evenly;
    flex-direction: column;
    align-content: stretch;
">';
			// echo'<table>';
			if ($usr['name'] == "RutBat") {
				$sql = "SELECT * FROM `user` ORDER BY region";
			} else {
				$sql = "SELECT * FROM `user` WHERE `region` LIKE '$usr[region]' ORDER BY region";
			}
			$res_data = mysqli_query($connect, $sql);
			while ($row = mysqli_fetch_array($res_data)) {
				$name = trim($row['name']);
				$region = trim($row['region']);
				$fio = trim($row['fio']);
				$email = trim($row['email']);
				$access = $row['access_date'];
				$id = $row['id'];
				if ($region == "01 - Север/Центр") {
					$bg_color = "#7fff0038";
				}
				if ($region == "02 - Восток") {
					$bg_color = "#816ecd38";
				}
				if ($region == "03 - Офис") {
					$bg_color = "#cd386269";
				}
				if ($region == "04 - Юго-Восток") {
					$bg_color = "#9f471d87";
				}
				if ($region == "05 - Новый мир") {
					$bg_color = "#85625287";
				}
				if ($region == "06 - Партизаны") {
					$bg_color = "#52856487";
				}
				if ($region == "07 - Юго-Запад") {
					$bg_color = "#47cd7687";
				}
				if ($region == "08 - Чистенькое") {
					$bg_color = "#63a11e87";
				}
				if ($region == "09 - Запад") {
					$bg_color = "#a11e9787";
				}
				if ($region == "10 - Москольцо") {
					$bg_color = "#74d4e387";
				}
				if ($region == "071 - Бахчисарай") {
					$bg_color = "#dfa46787";
				}
				if ($region == "12 - Зуя") {
					$bg_color = "#f9461187";
				}
				if ($region == "Проверочный регион") {
					$bg_color = "#4af91187";
				}
				$current_date = date('y-m-d');
				$access_date = $row['access_date'];
				$current_date = strtotime($current_date);
				$access_date = strtotime($access_date);
				if ($access_date >= $current_date) {
					$visible = 1;
					$color = "color:green;font-weight: bolder;font-size: 14px;";
				} else {
					$visible = 0;
					$color = "color:black;font-size: 13px;";
				}
			?>
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
				<div style='display: block;<?= $color; ?>background: <?= $bg_color; ?>
    			'>
					<?
					if ($visible) {
					?>
						<span>Подписка <br> [<?= $access ?>]</span>
					<?
					}
					?>
					<span>[<?= $region ?>]</span>
					<span><?php echo "$fio "; ?></span>
					<!-- / $name -->
					<a href="?edit=<?= $id ?>">
						<i class="edite_button fa-solid fa-user-pen"></i></i></a>
					<a href="JavaScript:startdel(<?= $id ?>)">
						<i style="padding: 0 10px 0;" class="delete_button fa-regular fa-trash-can"></i></i></a>
					</a>
				</div>
				<script type="text/javascript">
					function startdel(i) {
						if (confirm("Точно удалить пользователя из базы? Это безвозвратно")) {
							parent.location = 'del_user.php?id=' + i;
						}
					}
				</script>

		<?php
			}

			echo '</div>';
		}



		?>
		<div data-role="footer">
			<div class="d-grid gap-2">
				<a href="adm_setting.php?add_user" class="btn btn-success btn-lg">Добавить нового пользователя</a>
			</div>
		</div>
	</li>
</ul>
</div>
<?php
include 'inc/foot.php';
?>