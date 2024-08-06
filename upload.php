<?php
if (isset($_FILES['file'])) {
  $targetDir = './'; // Корневая директория для загрузки файла
  $targetFile = $targetDir . basename($_FILES['file']['name']);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Проверка, является ли файл изображением
  if (getimagesize($_FILES['file']['tmp_name']) === false) {
    echo 'Файл не является изображением.';
    $uploadOk = 0;
  }

  // Проверка наличия файла и его загрузка
  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
      echo '<img src="' . $targetFile . '" width="300" height="200" />';
    } else {
      echo 'Ошибка при загрузке файла.';
    }
  }
} else {
  echo 'Файл не был загружен.';
}
