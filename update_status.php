<?php
include('inc/db.php');
// Получение данных из запроса
$monId = isset($_POST['monId']) ? $_POST['monId'] : null;
$stat = isset($_POST['ajaxname']) ? $_POST['ajaxname'] : null;

// Обновление записи в базе данных
if (!is_null($monId) && !is_null($stat)) {
  $query = "UPDATE montaj SET `status` = $stat WHERE id = $monId";
  $result = $connect->query($query);
  if (!$result) {
    echo "Ошибка при обновлении записи в базе данных: " . $connect->error;
  }
}
