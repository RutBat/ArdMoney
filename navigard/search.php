<?php
include("inc/db.php");
if (!empty($_POST["referal"])) { //Принимаем данные
    $referal = trim(strip_tags(stripcslashes(htmlspecialchars($_POST["referal"]))));
    $db_referal = $mysqli -> query("SELECT * from adress WHERE adress LIKE '%$referal%'")
    or die('Ошибка №'.__LINE__.'<br>Обратитесь к администратору сайта пожалуйста, сообщив номер ошибки.');
    while ($row = $db_referal -> fetch_array()) {
        echo "\n<li>".$row["adress"]."</li>"; //$row["name"] - имя поля таблицы
    }
}
