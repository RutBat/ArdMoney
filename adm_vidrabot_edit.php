<?php
include "inc/head.php";
access();
AutorizeProtect();
global $connect;
global $usr;

// Проверяем, был ли отправлен запрос на редактирование
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $id = $_POST['id'];
    $newName = $_POST['new_name'];
    $newPriceTech = $_POST['new_price_tech'];
    $newRazdel = $_POST['new_razdel'];
    $newPrioritet = isset($_POST['new_prioritet']) ? 1 : 0;
    $newTypeKabel = $_POST['new_type_kabel'];
    $newText = $_POST['new_text'];
    $newIcon = $_POST['new_icon'];
    $newColor = $_POST['new_color'];

    // Поле price_full будет соответствовать price_tech
    $newPriceFull = $newPriceTech;

    // SQL-запрос для обновления данных в базе
    $updateSql = "UPDATE `vid_rabot` SET
        `name` = '$newName',
        `price_tech` = $newPriceTech,
        `price_full` = $newPriceFull,
        `razdel` = '$newRazdel',
        `prioritet` = $newPrioritet,
        `type_kabel` = '$newTypeKabel',
        `text` = '$newText',
        `icon` = '$newIcon',
        `color` = '$newColor'
        WHERE `id` = $id";

    // Выполнение SQL-запроса
    if (mysqli_query($connect, $updateSql)) {
        // После успешного обновления, перенаправляем обратно на страницу списка
        header("Location: adm_vidrabot.php");
        exit();
    } else {
        // Если возникла ошибка, вы можете обработать ее здесь
        echo "Ошибка при обновлении данных: " . mysqli_error($connect);
    }
}

// Получаем ID элемента, который нужно редактировать, из URL
$id = $_GET['id'];

// Выполняем запрос к базе данных для получения данных элемента
$sql = "SELECT * FROM `vid_rabot` WHERE `id` = $id";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// Выполняем запросы для получения уникальных значений для раздела, типа кабеля, и иконки
$razdelQuery = "SELECT DISTINCT `razdel` FROM `vid_rabot`";
$typeKabelQuery = "SELECT DISTINCT `type_kabel` FROM `vid_rabot`";
$iconQuery = "SELECT DISTINCT `icon` FROM `vid_rabot`";

$razdelResult = mysqli_query($connect, $razdelQuery);
$typeKabelResult = mysqli_query($connect, $typeKabelQuery);
$iconResult = mysqli_query($connect, $iconQuery);

// Получаем уникальные значения иконок
$icons = [];
while ($iconRow = mysqli_fetch_assoc($iconResult)) {
    $icons[] = $iconRow['icon'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование видов работ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="mt-4">
                <!-- Тут тело страницы -->
                <h2>
                    <a href="adm_vidrabot.php" class="btn btn-secondary btn-circle">
                        <i class="bi bi-arrow-left"></i>
                    </a> Редактирование вида работы
                </h2>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="new_name">Новое название:</label>
                        <input type="text" class="form-control" id="new_name" name="new_name" value="<?php echo $row['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="new_price_tech">Новая цена (техническая):</label>
                        <input type="text" class="form-control" id="new_price_tech" name="new_price_tech" value="<?php echo $row['price_tech']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="new_razdel">Новый раздел:</label>
                        <select class="form-control" id="new_razdel" name="new_razdel">
                            <?php
                            // Опции для раздела
                            while ($razdelRow = mysqli_fetch_assoc($razdelResult)) {
                                $selected = ($razdelRow['razdel'] == $row['razdel']) ? 'selected' : '';
                                echo '<option value="' . $razdelRow['razdel'] . '" ' . $selected . '>' . $razdelRow['razdel'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="new_prioritet" name="new_prioritet" <?php echo $row['prioritet'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="new_prioritet">Активный</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_type_kabel">Новый тип кабеля:</label>
                        <select class="form-control" id="new_type_kabel" name="new_type_kabel">
                            <?php
                            // Опции для типа кабеля
                            while ($typeKabelRow = mysqli_fetch_assoc($typeKabelResult)) {
                                $selected = ($typeKabelRow['type_kabel'] == $row['type_kabel']) ? 'selected' : '';
                                echo '<option value="' . $typeKabelRow['type_kabel'] . '" ' . $selected . '>' . $typeKabelRow['type_kabel'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="new_text">Новый текст:</label>
                        <textarea class="form-control" id="new_text" name="new_text"><?php echo $row['text']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="new_icon">Новая иконка:</label>
                        <select class="form-control" id="new_icon" name="new_icon">
                            <?php
                            // Опции для иконки
                            foreach ($icons as $icon) {
                                $selected = ($icon == $row['icon']) ? 'selected' : '';
                                // Создаем элемент <i> с классами Bootstrap иконок внутри <option>
                                echo '<option value="' . $icon . '" ' . $selected . '><i class="' . $icon . '"></i> ' . $icon . '</option>';
                            }
                            ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="new_color">Новый цвет:</label>
                        <input type="color" class="form-control" id="new_color" name="new_color" value="<?php echo $row['color']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/js/searcher.js"></script>
</body>

</html>

<?php
include 'inc/foot.php';
?>