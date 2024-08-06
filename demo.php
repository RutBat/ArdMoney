<?php
include "inc/head.php";
AutorizeProtect();
access();
global $connect;
global $usr;
?>

<head>
    <title>Инструкция</title>
</head>
<figure class="text-center">
    <blockquote class="blockquote">
        <p>Учтите это не бесплатное ПО. <br>Стоимость 200р/мес. <br>После регистрации своего аккаунта будет показана инструкция для оплаты.</p>
    </blockquote>
</figure>
<ul class="list-group">
    <li class="text-center list-group-item-success list-group-item">Список заявок</li>
    <li class="list-group-item">
        В этом пункте находятся все ваши монтажи.<br>
        <center><img src="img/ins/9.png" alt="" width="50%"></center><br>
        <span style="color:red;font-weight: 700;">Красным цветом</span> выделены монтажи за СЕГОДНЯ.<br>
        <span style="color:green;font-weight: 700;">Зеленым цветом</span> выделены монтажи которые соответствуют базе.<br>
        <span style="color:black;font-weight: 700;">Черным цветом</span> выделены все остальные монтажи требующие внимания и сверки с базой<br>
    </li>
    <li class="text-center list-group-item-success list-group-item">Добавление заявок</li>
    <li class="list-group-item">
        Этот пункт служит для создания заявки в которую вносятся монтажи.<br>
        <center><img src="img/ins/8.png" alt="" width="50%"></center><br>
        В поле адрес пишем адрес для ориентира (хоть 5 столб в поле) это нужно для удобного поиска монтажей<br>
        В кратком описании нужно вписать что примерно там делал, мало ли на одном адресе был 20 раз за день.<br>
        Укажите с кем монтажили, это нельзя отредактировать потом!<br>
        Так же сверху в выпадающем списке находятся месяца, выбрав нужный можно посмотреть свои монтажи за выбранный месяц.<br>
    </li>
    <li class="text-center list-group-item-success list-group-item">Добавление монтажей</li>
    <li class="list-group-item">
        В данном меню есть выпадающий список и количество.<br>
        Если монтаж единичный то обязательно ставим цифру <b>1</b>, не пишите 1м. 1шт. Просто цифру!. <br>
        К примеру <b>Подключение</b> - <b>1</b><br>
        Если монтажа нет в списках то выбираем пункт <b>Другое</b> и указываем стоимость.<br>
        <img src="img/ins/2.png" alt="" width="100%">
        <big><b>Важный момент</b></big><br>
        <b>При выборе пункта Другое ОБЯЗАТЕЛЬНО нажмите на строку и измените название с Другое на то что делали и сумму <br>
            <img src="img/ins/3.png" alt="" width="100%">
            Например: <br>
            Купили председателю резиновый член - 2000</b><br>
        <img src="img/ins/4.png" alt="" width="100%">
    </li>
    <li class="text-center list-group-item-success list-group-item">Удаление монтажей</li>
    <li class="list-group-item">
        При нажатии кнопки удаления монтажей <img src="img/ins/7.png" width="100px" alt=""> они удаляются сразу, не спрашивая точно ли хотите удалить<br>
    </li>
    <li class="text-center list-group-item-success list-group-item">Страница пользователя</li>
    <li class="list-group-item ">
        Тут можно смотреть сколько ты намонтажил за месяц и количество монтажей <br>
        В пункте <img src="img/ins/5.png" width="200px" alt=""> находятся итог по монтажам за выбранный вами месяц прошлого года.<br>
        В пункте <img src="img/ins/6.png" width="200px" alt=""> находятся монтажи за прошлый год. Навигация выполняется по месяцам прошлого года<br>
    </li>
</ul>
<?php include 'inc/foot.php';
?>