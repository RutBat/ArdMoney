<?php
include('inc/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $text = $_POST['text'];

  // Обновляем значение в базе данных
  $query = "UPDATE `montaj` SET `text` = '$text' WHERE `id` = $id";
  $result = mysqli_query($connect, $query);

  if ($result) {
    echo "Значение обновлено";
  } else {
    echo "Ошибка при обновлении значения";
  }
}
