<?php
include "inc/function.php";

$uploadDir = 'img/screen/';
// Папка, в которую будет загружаться изображение
$append = "$_POST[id].png";
// Полный путь к измененному файлу
$originalFile = "$uploadDir$append";
// Полный путь к исходному файлу

// Проверяем, проходит ли изображение по размеру (до 200 МБ)
if (
    ($_FILES['userfile']['type'] == 'image/gif' ||
        $_FILES['userfile']['type'] == 'image/jpeg' ||
        $_FILES['userfile']['type'] == 'image/png') &&
    ($_FILES['userfile']['size'] != 0 && $_FILES['userfile']['size'] <= 200000000)
) {
    // Загружаем исходное изображение
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $originalFile)) {
        // Загружаем файл

        // Здесь идет процесс загрузки измененного изображения (2:1)
        list($width, $height) = getimagesize($originalFile);
        $aspectRatio = 2; // Соотношение сторон 2:1
        $newWidth = $width;
        $newHeight = $width / $aspectRatio;

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        $sourceImage = imagecreatefromstring(file_get_contents($originalFile));

        imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);


        // Добавьте здесь свой код для обработки исходного изображения, если необходимо

        redir("result.php?vid_id=$_POST[id]", "1");
    } else {
        echo "Файл не загружен, вернитесь и попробуйте еще раз";
    }
} else {
    echo "Что-то пошло не так или размер файла превышает 200 МБ, заебал))";
}
