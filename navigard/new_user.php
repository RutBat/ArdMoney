<?php
include "inc/head.php"; 
AutorizeProtect();
global $connect;
global $usr;
?>
<form method="GET" action="reg.php">
	<div class="form-row">
		<div class="col-md-8 col-sm-12  mx-auto">
			<li class="list-group-item">
				<input type="text" name="login" class="form-control" required title="Введите от 4 символов" placeholder="Логин">
				<input type="text" name="pass" class="form-control" required title="Введите от 4 символов" placeholder="Пароль">
				<?php
				echo '<small  class="text-danger form-text">Регион</small><select name="region" class="custom-select mr-sm-2">';
					$reg = $connect->query("SELECT * FROM region ");
					while ($region = $reg->fetch_object()) {
					echo "<option value='$region->name'>$region->name</option>";
					}
				echo '</select>';
				?>
				
			<button type="submit" class="btn btn-primary btn-lg btn-block">Регистрация</button></li>
		</div>	</div>
	</form>
</div>
<?php include 'inc/foot.php';
?>