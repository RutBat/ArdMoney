<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Я того рот загружал</title>
    <!-- Подключение Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Подключение кастомных стилей -->
    <style>
        .container {
            margin-top: 20px;
        }

        body {
            background: rgb(238, 174, 202);
            background: linear-gradient(90deg, rgba(238, 174, 202, 1) 0%, rgba(148, 187, 233, 0.4234068627450981) 100%);
        }

        .container {
            background: rgb(247 240 243);
            background: linear-gradient(180deg, #dac6db 0%, rgb(191 207 225) 100%);
            margin: 0rem 0rem 8rem 0rem;
        }
    </style>

</head>

<body>
    <div class="container">
        <br>
        <br>
        <br>
        <br>
        <br>
        <h1 class="text-center">Я того рот загружал</h1>

        <!-- Форма для загрузки файла -->
        <form action="rutdown.php" method="POST" enctype="multipart/form-data">
            <div class="form-file-lg mb-3">

                <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload">
            </div>
            <button type="submit" class="btn btn-block btn-success btn-lg" name="submit">Загрузить файл</button>
        </form>

        <h2 class="mt-5">Список файлов:</h2>
        <ul class="list-group pb-5">
            <!-- PHP-код для обработки загрузки файла и вывода списка файлов -->
            <?php
            $target_dir = "uploads/"; // Путь к папке, где будут храниться загруженные файлы
            $uploadOk = 1;

            // Функция для получения списка файлов в указанной директории
            function getFilesInDirectory($directory)
            {
                $files = array_diff(scandir($directory), array('..', '.'));
                return $files;
            }

            // Получаем список файлов в директории и отображаем их
            $files = getFilesInDirectory($target_dir);
            foreach ($files as $file) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                        <a href='$target_dir/$file'>$file</a>
                        <span class='btn-group'>
                            <form method='POST' action='rutdown.php' style='display: inline-block;'>
                                <input type='hidden' name='delete' value='$file'>
                                <button class='btn btn-danger btn-sm' onclick='return confirmDelete(\"$file\")'><i class='fa fa-trash'></i></button>
                            </form>
                            <button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#renameFileModal' data-file='$file' data-old-file='$file'><i class='fa fa-edit'></i></button>
                        </span>
                      </li>";
            }

            if (isset($_POST["submit"])) {
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if ($fileType === "apk") { // Проверка расширения файла
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        header("Location: rutdown.php"); // Перенаправление после успешной загрузки файла
                    } else {
                        echo "<li class='list-group-item'>Произошла ошибка при загрузке файла.</li>";
                    }
                } else {
                    echo "<li class='list-group-item'>Извините, разрешены только файлы с расширением .apk.</li>";
                }
            }

            if (isset($_POST["delete"])) {
                $fileToDelete = $_POST["delete"];
                $fullPath = $target_dir . $fileToDelete;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    header("Location: rutdown.php"); // Перенаправление после удаления файла
                }
            }

            if (isset($_POST["rename"])) {
                $newFileName = $_POST["newFileName"];
                $oldFileName = $_POST["oldFileName"];
                $oldFullPath = $target_dir . $oldFileName;
                $newFullPath = $target_dir . $newFileName;

                if (file_exists($oldFullPath)) {
                    rename($oldFullPath, $newFullPath);
                    header("Location: rutdown.php"); // Перенаправление после изменения имени файла
                }
            }
            ?>
        </ul>
    </div>

    <!-- Подключение Bootstrap CSS (FontAwesome для иконок) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        function confirmDelete(fileName) {
            if (confirm("Вы уверены, что хотите удалить файл " + fileName + "?")) {
                return true;
            }
            return false;
        }
    </script>

    <!-- Подключение jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Подключение Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Обработчик для кнопки редактирования в модальном окне
        $(document).ready(function() {
            $('#renameFileModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // Кнопка, которая открыла модальное окно
                const file = button.data('file'); // Имя файла
                const oldFile = button.data('old-file'); // Старое имя файла
                const modal = $(this);
                modal.find('#oldFileName').val(oldFile); // Устанавливаем старое имя файла в скрытое поле
                modal.find('#newFileName').val(file); // Устанавливаем текущее имя файла в поле для редактирования
            });

            // Обработчик для кнопки "Сохранить" в модальном окне
            $('#renameSubmit').click(function() {
                const newFileName = $('#newFileName').val();
                const oldFileName = $('#oldFileName').val();

                if (newFileName !== oldFileName) {
                    // Отправляем данные на сервер для изменения имени файла
                    $.post('rename.php', {
                        oldFileName: oldFileName,
                        newFileName: newFileName
                    }, function(data) {
                        if (data.success) {
                            // Если успешно изменено, обновляем текст ссылки и закрываем модальное окно
                            $('a[href="' + oldFileName + '"]').text(newFileName);
                            $('#renameFileModal').modal('hide');
                            // Перезагрузка страницы
                            location.reload();
                        } else {
                            // Выводим сообщение об ошибке, если что-то пошло не так
                            alert('Ошибка при изменении имени файла.');
                        }
                    }, 'json');
                } else {
                    // Если новое имя такое же, как старое, просто закрываем модальное окно
                    $('#renameFileModal').modal('hide');
                }
            });
        });
    </script>


    <div class="modal fade" id="renameFileModal" tabindex="-1" role="dialog" aria-labelledby="renameFileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renameFileModalLabel">Изменение имени файла</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="rutdown.php" id="renameForm">
                        <div class="form-group">
                            <label for="newFileName">Новое имя файла:</label>
                            <input type="text" class="form-control" id="newFileName" name="newFileName">
                            <input type="hidden" id="oldFileName" name="oldFileName">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" id="renameSubmit">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>