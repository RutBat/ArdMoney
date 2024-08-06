<?php
include('inc/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $adress = $_POST['adress'];

  // Обновляем значение в базе данных
  $query = "UPDATE `montaj` SET `adress` = '$adress' WHERE `id` = $id";
  $result = mysqli_query($connect, $query);

  if ($result) {
    echo "Значение обновлено";
  } else {
    echo "Ошибка при обновлении значения";
  }
}
