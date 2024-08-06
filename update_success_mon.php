<?php
include('inc/db.php');
// Получение данных из запроса
$userId = isset($_POST['userId']) ? $_POST['userId'] : null;
$update_success_mon = isset($_POST['update_success_mon']) ? $_POST['update_success_mon'] : null;

// Обновление записи в базе данных
if (!is_null($userId) && !is_null($update_success_mon)) {
  $query = "UPDATE user SET update_success_mon = $update_success_mon WHERE id = $userId";
  $result = $connect->query($query); // Исправлено на $db
  if (!$result) {
    echo "Ошибка при обновлении записи в базе данных: " . $connect->error; // Исправлено на $db
  }
}
