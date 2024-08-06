<?php

include "inc/head.php";

AutorizeProtect();
global $connect;
global $usr;
if(isset($_GET['success'])){
		alrt("Пользователь $_GET[id] отредактирован", "success", "100000000");
}
if(isset($_GET['del_ok'])){
		alrt("Пользователь удалён", "success", "100000000");
}
///////проверка на админа///////
    $admin = $usr['admin'];
    if($admin == 0){

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

    if($usr['admin'] == 1){










//Редактирование пользователя//
if(!empty($_GET['edit'])){



echo'<form action= "edit_user_obr.php" method = "GET">';

echo'<div class="input-group mb-3">';
echo'<table>';
$id_user = $_GET['edit'];
$sql = "SELECT * FROM user WHERE id = $id_user ";
$res_data = mysqli_query($connect, $sql);
while($row = mysqli_fetch_array($res_data)){
$name = trim($row['name']);
$fio = trim($row['fio']);
$email = trim($row['email']);
$admin = trim($row['admin']);
$id = trim($row['id']);
$region_user = trim($row['region']);
$id = $row['id'];
$admin = $row['admin'];
?>
		<tr>
			<td>
				<small class="text-danger form-text">Смена пароля производится персонально, через администратора приложения:
					<b>Ершова
						Н.Н.</b><br>Пароль нельзя <b>узнать</b>, можно только <b>сменить</b> на новый!</small><br>
				<small class="text-mute form-text">Имя</small>
				<div class="input-group mb-3">
					<input type="hidden" name="id" value="<?=$id?>">
					<input type="text" name="name" class="form-control" placeholder="Имя" value="<?=$name?>">
				</div>
				<small class="text-mute form-text">Почта</small>
				<div class="input-group mb-3">
					<input type="text" name="email" class="form-control" placeholder="Почта" value="<?=$email?>">
				</div>
				<small class="text-danger form-text">Регион</small><select name="region" class="form-select mr-sm-2">
                    <?php

								$reg = $connect->query("SELECT * FROM region ");
                while ($region = $reg->fetch_object()) {
									if($region_user == $region->name){$sel_region = "selected";}else{$sel_region= "";}
                    echo "<option name = 'region' $sel_region value='$region->name'>$region->name</option>";
                }



                echo '</select>';
if($admin == 1){
	$checked = "checked";
	$admin = 1;
}else{
	$checked = "";
	$admin = 0;
}



?>




					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" name="admin" id="flexSwitchCheckChecked" <?=$checked?>>
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







    echo'<div
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
		echo'<table>';
        $sql = "SELECT * FROM user ORDER BY id";
        $res_data = mysqli_query($connect, $sql);
        while($row = mysqli_fetch_array($res_data)){
        $name = trim($row['name']);
				$fio = trim($row['fio']);
				$email = trim($row['email']);
        $region = trim($row['region']);
				$id = $row['id'];
        ?>
		<tr style="
		border-color: grey;
    border-style: dotted;
    border-width: 1px;
		">

			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
				integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
				crossorigin="anonymous" referrerpolicy="no-referrer" />
			<td>
				<span style="font-size: 8pt;">[<?=$region?>]</span>
			</td>
			<td>
				<span style="font-size: 10pt;color:green;"><?=$email?></span>
				<br>
				<span style="font-weight: 700;"><?php echo"$fio / $name";?></span>
			</td>

			<td>
				<a href="?edit=<?=$id?>">
					<i class="edite_button fa-solid fa-user-pen"></i></i></a>
				<a href="JavaScript:startdel(<?=$id?>)">
					<i style="padding: 0 10px 0;" class="delete_button fa-regular fa-trash-can"></i></i></a>
				</a>
			</td>
		</tr>
		<script type="text/javascript">
		function startdel(i) {

			if (confirm("Точно удалить пользователя из базы? Это безвозвратно")) {

				parent.location = 'del_user.php?id=' + i;

			}

		}
		</script>
        <?php
				}

		echo'</table></div>';









    }
?>

	</li>

</ul>

</div>


<?php
include 'inc/foot.php';

?>