<?php
session_start();
include "inc/head.php";
AutorizeProtect();
$adress = trim(h($_GET['adress']));
?>
<head>
	<title>Перевод на PON
	<?=$adress?>
	</title>
		<script type="text/javascript" src="searcher.js"></script>
</head>
<?php
echo '<ul class="list-group"><form method = "GET" action = "perevod_add.php"  >';
print '
<small  class="form-text text-muted">Адрес абонента</small>
<input name = "adress"
type="text"
class="form-control"
placeholder="Адрес абонента">
';
echo'<input type="text" autocomplete="off" id="search" name="adress" class="form-control" required title="Введите от 4 символов" placeholder="Введите адрес">
				
				<ul class="list-group">
					<div id="display"></div>
				</ul>';
echo '<button type="submit" class="btn btn-primary btn-lg btn-block">Добавить абонента</button></li>
</form>
</ul>';
include 'inc/foot.php';