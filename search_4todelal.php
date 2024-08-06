<?php
include('inc/db.php');
// Проверка подключения к базе данных
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Получение поискового запроса из поля ввода
$searchTerm = $_POST['search'];

// Поиск соответствий в базе данных
$sql = "SELECT DISTINCT text FROM montaj WHERE text LIKE '%$searchTerm%' LIMIT 5";
$result = $connect->query($sql);

// Формирование списка результатов в формате JSON
$results = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results[] = array("text" => $row["text"]);
    }
}
echo json_encode($results);

// Закрытие подключения к базе данных
$connect->close();
