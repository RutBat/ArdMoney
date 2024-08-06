<?php
include('inc/db.php');
if (!$connect) {
  die("Ошибка подключения: " . mysqli_connect_error());
}

// Получаем данные из AJAX-запроса
$action = $_POST["action"];
$username = $_POST["username"];

if ($action === "enable") {
  $admin_view = 1;
} elseif ($action === "disable") {
  $admin_view = 0;
} else {
  die("Недопустимое действие");
}

// Обновляем значение admin_view в базе данных
$query = "UPDATE user SET admin_view = $admin_view WHERE name = '$username'";

if (mysqli_query($connect, $query)) {
  echo "Значение admin_view успешно обновлено.";
} else {
  echo "Ошибка при обновлении значения admin_view: " . mysqli_error($connect);
}
