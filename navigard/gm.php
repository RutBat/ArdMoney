<?php
include "inc/head.php";
AutorizeProtect();
global $connect;
global $usr;
?>

<head>
	<title>Админ панель</title>
</head>
<?php
echo'<form method="GET" action="#">';
echo'<li class="list-group-item  justify-content-between align-items-center">';
	////////////////////////////РЕГИОН////////////////////////////////////////////////
	if ($usr['admin'] == '1') {

	?>
<style>
.table th,
.table td {
	padding: 9px 6px;
	vertical-align: top;
	border-top: 1px solid #dee2e6;
}
</style>
<h5>Таблица отображает количество домов в регионах и их завершенность</h5>
<table class="table">
	<thead>
		<tr>
			<th scope="col">№</th>
			<th scope="col">Регион</th>
			<th scope="col">Всего</th>
			<th scope="col">Готовых</th>
			<th scope="col">%</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$results = $connect->query("SELECT * FROM region ");
			while ($row = $results->fetch_object()) {
			$adrs = $connect->query("SELECT * FROM `adress` WHERE `region` = '$row->name' ");
			$complete = $connect->query("SELECT * FROM `adress` WHERE `region` = '$row->name' AND complete = 1");
			$percent = ($complete->num_rows / $adrs->num_rows)	* 100;
			$percent = round($percent,2);
			if(is_nan($percent) == "FALSE"){
            $percent = 0;
			}else{
				$percent = round($percent,2);
			}

			//$percent = is_nan($percent == FALSE) ? 0 : (float)round($percent,2)*1;
			$adress = $adrs->fetch_array(MYSQLI_ASSOC);
			?>
		<tr>
			<th scope="row"><?=$row->id?></th>
			<td><?=$row->name?></td>
			<td><?=$adrs->num_rows?></td>
			<td><?=$complete->num_rows?></td>
			<td><?=$percent?>%</td>
		</tr>
                <?php
			}

		echo'</tbody>
	</table>';
		}
echo'</li>';
echo'</form>';
echo'</div>';
include 'inc/foot.php';
exit();