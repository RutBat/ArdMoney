<?php

include "inc/head.php";

AutorizeProtect();
global $connect;
global $usr;
?>

<ul class="list-group">

    <li class="list-group-item">

        <?php

        $uploaddir = 'img/';

        // это папка, в которую будет загружаться картинка

        $apend="$usr[name].png";

        // это имя, которое будет присвоенно изображению

        $uploadfile = "$uploaddir$apend";

        //в переменную $uploadfile будет входить папка и имя изображения

        // В данной строке самое важное - проверяем загружается ли изображение (а может вредоносный код?)

        // И проходит ли изображение по весу. В нашем случае до 512 Кб

        if ((

            $_FILES['userfile']['type'] == 'image/gif' ||

            $_FILES['userfile']['type'] == 'image/jpeg' ||

            $_FILES['userfile']['type'] == 'image/png') && ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size']<=1024000000)) {
            

           




            function resize($image, $w_o = false, $h_o = false)
            {
                if (($w_o < 0) || ($h_o < 0)) {
                    echo "Некорректные входные параметры";
                    return false;
                }
                list($w_i, $h_i, $type) = getimagesize($image); // Получаем размеры и тип изображения (число)
                $types = array("jpg", "gif", "jpeg", "png"); // Массив с типами изображений
                $ext = $types[$type]; // Зная "числовой" тип изображения, узнаём название типа
                if ($ext) {
                    $func = 'imagecreatefrom'.$ext; // Получаем название функции, соответствующую типу, для создания изображения
                    $img_i = $func($image); // Создаём дескриптор для работы с исходным изображением
                } else {
                    echo 'Некорректное изображение'; // Выводим ошибку, если формат изображения недопустимый
                    return false;
                }
        /* Если указать только 1 параметр, то второй подстроится пропорционально */
                if (!$h_o) {
                    $h_o = $w_o / ($w_i / $h_i);
                }
                if (!$w_o) {
                    $w_o = $h_o / ($h_i / $w_i);
                }
                $img_o = imagecreatetruecolor($w_o, $h_o); // Создаём дескриптор для выходного изображения
                imagecopyresampled($img_o, $img_i, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i); // Переносим изображение из исходного в выходное, масштабируя его
                $func = 'image'.$ext; // Получаем функция для сохранения результата
                return $func($img_o, $image); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции
            }
      
            







        // Указываем максимальный вес загружаемого файла.

            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            //Здесь идет процесс загрузки изображения

                $uploadfile = resize("$uploadfile", 128, 128); // Вызываем функцию

                $size = getimagesize($uploadfile);

            // с помощью этой функции мы можем получить размер пикселей изображения

                if ($size[0] < 12800 && $size[1]<12500) {
                    alrt("Файл загружен", "success", "1");
                    redir("user", "1");
                } else {
                    echo "Загружаемое изображение превышает допустимые нормы (ширина не более - 800; высота не более 1500)";

                    unlink($uploadfile);

                // удаление файла
                }
            } else {
                echo "Файл не загружен, вернитеcь и попробуйте еще раз";
            }
        } else {
            echo "Размер файла не должен превышать 1mb";
        } ?>

    </li>

</ul>

<?php include 'inc/foot.php';?>