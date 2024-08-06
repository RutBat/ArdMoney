<?php
include('inc/db.php');
// Получение данных из запроса
$userId = isset($_POST['userId']) ? $_POST['userId'] : null;
$adminView = isset($_POST['adminView']) ? $_POST['adminView'] : null;

// Обновление записи в базе данных
if (!is_null($userId) && !is_null($adminView)) {
  $query = "UPDATE user SET admin_view = $adminView WHERE id = $userId";
  $result = $connect->query($query);
  if (!$result) {
    echo "Ошибка при обновлении записи в базе данных: " . $connect->error;
  }
}
