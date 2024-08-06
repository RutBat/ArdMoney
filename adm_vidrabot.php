<?php
include "inc/head.php";
access();
AutorizeProtect();
global $connect;
global $usr;

// Проверяем, был ли отправлен запрос на удаление
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteSql = "DELETE FROM `vid_rabot` WHERE `id` = $deleteId";
    if (mysqli_query($connect, $deleteSql)) {
        // Успешное удаление, можно выполнить дополнительные действия, если необходимо
    } else {
        // Обработка ошибки удаления
        echo "Ошибка при удалении записи: " . mysqli_error($connect);
    }
}

// Выполняем запрос к базе данных для получения списка видов работ
$sql = "SELECT `id`, `name` , `color`  FROM `vid_rabot` ORDER BY `type_kabel`";
$result = mysqli_query($connect, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список видов работ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .highlighted {
            background-color: yellow;
        }
    </style>
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="mt-4">
                <h2>Список видов работ:</h2>
                <a href="adm_vidrabot_add.php" class="btn btn-primary btn-block">Добавить новую запись</a>
                <div class="input-group mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Поиск..." oninput="liveSearch()">
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1; // Счетчик для порядкового номера
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr id="skrivat" class="search-view" data-value="' . htmlspecialchars($row['name']) . '">';
                            echo '<td>' . $counter . '</td>';
                            echo '<td style="color:' . $row['color'] . ';">' . $row['name'] . '</td>';
                            echo '<td><a href="adm_vidrabot_edit.php?id=' . $row['id'] . '"><i style="color:' . $row['color'] . '; font-size: 24px;" class="bi bi-pencil-square"></i></a> | ';
                            echo '<a href="?delete_id=' . $row['id'] . '"><i style="color:' . $row['color'] . '; font-size: 24px;"  class="bi bi-trash"></i></a></td>';
                            echo '</tr>';
                            $counter++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


</body>

</html>

<?php
// живой поиск
//LiveSearch('ПОЛЕ ВВОДА spterm', 'ГДЕ ИСКАТЬ search_view', 'БЛОК ДЛЯ СКРЫТИЯ#skrivat');
// data-value в блоке где будет поиск должен содержать
// в себе имя или что то похожее для поиска соответствий
//например
//data-value="' . htmlspecialchars($row['name']) . '"
LiveSearch('searchInput', 'search-view', '#skrivat');

include 'inc/foot.php';
?>