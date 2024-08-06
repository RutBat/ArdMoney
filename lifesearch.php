<?php
include "inc/db.php";
global $connect;
if (isset($_POST['search'])) {
	$Name = htmlspecialchars(htmlentities($_POST['search']));
	$Query = "SELECT * FROM montaj WHERE adress LIKE '%$Name%' LIMIT 3";

	$ExecQuery = mysqli_query($connect, $Query);
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
		<li class="search-result list-group-item pizdec" onclick='fill("<?php echo $Result['adress']; ?>")'>
			<a><span style="color:gray;font-size:0.5rem;">
					<?= $Result["date"] ?>
				</span>
				<?php echo $Result['adress']; ?>
			</a>
		</li>
<?php
	}
}
?>
</ul>