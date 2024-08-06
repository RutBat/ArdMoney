<?php
include "inc/head.php";
AutorizeProtect();
?>

<head>
	<title>NavigArd - ваш навигатор доступа к оборудованию</title>
	<script type="text/javascript" src="searcher.js"></script>
</head>
<div class="container">

	<br>
	<div style="padding: 15% 28px 0; text-align: center;"><b>
			<span style="font-family:'Ardinvest',serif;font-style: italic;">
				NavigArd
			</span>
		</b>ваш навигатор доступа к
		оборудованию
		<br>Пример:
		<i>
			<b>
				<span style="color: red; ">Набережная 85</span>
			</b> или просто
			<b>
				<span style="color: red; ">Набережная</span>
			</b>
		</i> <br>
		<small><b><a href="/ins">Инструкция пользования</a></b></small>
	</div>
	<br>
	<form id='ard' method="GET" action="result.php">
		<div class="row g-3" ">
			<div class="col-9">
				<input type="text" autocomplete="off" id="search" name="adress" class="form-control" required
					title="Введите от 4 символов" placeholder="Введите адрес">
				<div id="display"></div>
			</div>
			<div class="col-3 block">
				<a onclick="document.getElementById('ard').submit()" class="block btn btn_main">Поиск</a>
			</div>
		</div>
	</form>
</div>
</div>
<?php include 'inc/foot.php';?>