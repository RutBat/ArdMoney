<?php
include "inc/head.php";
access();
AutorizeProtect();
global $connect;
global $usr;

// Проверяем, был ли отправлен запрос на добавление
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price_tech = $_POST['price_tech'];
    $razdel = $_POST['razdel'];
    $prioritet = $_POST['prioritet'];
    $type_kabel = $_POST['type_kabel'];
    $text = $_POST['text'];
    $icon = $_POST['icon'];
    $color = $_POST['color'];

    $insertSql = "INSERT INTO `vid_rabot` (`name`, `price_tech`, `price_full`, `razdel`, `prioritet`, `type_kabel`, `text`, `icon`, `color`)
                  VALUES ('$name', '$price_tech', '$price_tech', '$razdel', '$prioritet', '$type_kabel', '$text', '$icon', '$color')";

    if (mysqli_query($connect, $insertSql)) {
        // Успешное добавление, очищаем форму
        $_POST = array();
		alrt("Успешно добавили - $name", "success", "10");

        redir("adm_vidrabot.php", 2);
    } else {
        // Обработка ошибки добавления
        echo "Ошибка при добавлении записи: " . mysqli_error($connect);
    }
}

// Выполняем запрос к базе данных для получения списка уникальных значений razdel, icon и color
$sql = "SELECT DISTINCT `razdel` FROM `vid_rabot`";
$resultRazdel = mysqli_query($connect, $sql);

$sql = "SELECT DISTINCT `icon` FROM `vid_rabot`";
$resultIcon = mysqli_query($connect, $sql);

$sql = "SELECT DISTINCT `color` FROM `vid_rabot`";
$resultColor = mysqli_query($connect, $sql);

$sql = "SELECT DISTINCT `type_kabel` FROM `vid_rabot`";
$resultTypeKabel = mysqli_query($connect, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление новой записи</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 mt-4">
                <h2 class="text-center">Добавление новых видов работ</h2>
                <!-- Форма для добавления новой записи -->
                <form method="post">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="price_tech">Цена (техническая)</label>
                        <input type="text" class="form-control" id="price_tech" name="price_tech" required>
                    </div>
                    <div class="form-group">
                        <label for="razdel">Раздел</label>
                        <select class="form-control" id="razdel" name="razdel" required>
                            <!-- Опции для выбора раздела -->
                            <?php
                            while ($row = mysqli_fetch_assoc($resultRazdel)) {
                                echo '<option value="' . $row['razdel'] . '">' . $row['razdel'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prioritet">Приоритет</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="prioritet" name="prioritet" value="1">
                            <label class="form-check-label" for="prioritet">Активный</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type_kabel">Тип кабеля</label>
                        <select class="form-control" id="type_kabel" name="type_kabel" required>
                            <!-- Опции для выбора типа кабеля -->
                            <?php
                            while ($row = mysqli_fetch_assoc($resultTypeKabel)) {
                                echo '<option value="' . $row['type_kabel'] . '">' . $row['type_kabel'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="text">Текст</label>
                        <input type="text" class="form-control" id="text" name="text" value="Текст заглушка" readonly>
                    </div>
                    <div class="form-group">
                        <label for="icon">Иконка</label>
                        <select class="form-control" id="icon" name="icon" required>
                            <!-- Опции для выбора иконки -->
                            <?php
                            while ($row = mysqli_fetch_assoc($resultIcon)) {
                                echo '<option value="' . $row['icon'] . '">' . $row['icon'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="color">Цвет</label>
                        <select class="form-control" id="color" name="color" required>
                            <!-- Опции для выбора цвета -->
                            <?php
                            while ($row = mysqli_fetch_assoc($resultColor)) {
                                echo '<option value="' . $row['color'] . '">' . $row['color'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Добавить</button>
                </form>
                <!-- Остальное содержимое страницы -->
                <!-- ... -->
            </div>
        </div>
    </div>
</body>

</html>

<?php
include 'inc/foot.php';
?>