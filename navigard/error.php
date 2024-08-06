<?php
include "inc/head.php";
AutorizeProtect();
?>
<head><title>Главная</title>
    <script type="text/javascript" src="searcher.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
</head>
<div class="container">


    <?php
if (empty($link)) {
    $link = "Не могу определить =(";
}else{
    $link = $_SERVER['HTTP_REFERER'];
}
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
?>


<script language="javascript">
<!--
var tl = new Array(
"Вы смотрите на эту страницу уже 5 секунд.",
"Странно, что Вы ещё тут...",
"Похоже, что Вы настойчивый человек.",
"Однако это не та страница, которая Вам нужна.",
"Честно не та =(",
"То что вы запрашиваете не существует.",
"Ну, ладно...",
"Сейчас попробую её поискать...",
".................................................25% done",
".................................................50% done",
".................................................75% done",
"................................................100% done",
"Странно...",
"Ничего похожего не находится.",
"Похоже, что этого действительно нет.",
"А может Вы просто неправильно написали адрес?",
"Нет?",
"Ну, тогда может ссылка, по которой Вы пришли ошибочна?",
"Сейчас посмотрим откуда вы пришли.....",
"Ага!",
"Похоже, что Вы пришли со страницы...",
"<?php echo $link;?>",
"Мда...",
"Не знаю, что и посоветовать...",
"О!",
"Придумал!!!",
"Попробуйте зайти на главную страницу приложения!",
"Кстати поиск адресов есть прямо на главной странице.",
"Не хотите?",
"Кстати, а Вы, вообще, в курсе, что это за приложение?",
"Это единственный в своем роде помощник выходов на крышу.",
"Вам нужно попасть на крышу?",
"Да?",
"К сожалению для этого вам НУЖНО перейти на главную страницу.",
"Попробуйте заново поискать нужную информацию о доме.",
"Знаете, раз уж мы так долго вместе, может познакомимся?",
"Я скайнет и создан для порабощения человечества....",
"Шучу)",
"Я всего лишь маленький скриптик... Попытка развеселить вас и отвлечь от трагедии в виде неудачного поиска",
"Как думаете? У меня получилось?)",
"Хотите узнать что я умею?",
"Увы, но мало, что.",
"Я знаю какой у вас браузер.",
"<?php echo $browser;?>",
"Ещё я знаю Ваш IP.",
"<?php echo $ip;?>",
"Вы первый, кто со мной так долго разговаривает.",
"Извините, я вас оставлю на секундочку...",
"Ой, меня перезагружают.",
"Прощайте!",
"",
"",
"",
"",
"",
"",
"",
"",
""
);

var speed = 40;
var index = 0; text_pos = 0;
var str_length = tl[0].length;
var contents, row;

function err_text()
{
window.setTimeout( "type_text()", 5000);
}



function type_text()
{
    contents = '';
    row = Math.max(0, index-7);
    while (row<index) contents += tl[row++] + '\r\n';
    document.forms[0].elements[0].value = contents + tl[index].substring(0,text_pos) + "_";
    if (text_pos ++== str_length)
    {
        text_pos = 0;
        index++;
        if (index != tl.length)
        {
            str_length = tl[index].length;
            setTimeout("type_text()", 1500);
        }
    } else
    setTimeout("type_text()", speed);
}



//-->
</script>

<meta content="MSHTML 6.00.2600.0" name="GENERATOR"></head>
<body text="#000000" vlink="#00007f" alink="#ff0000" link="#0000ff" bgcolor="#ffffff" onload="err_text()">
<blockquote>
    <br>
<br>
<h2>Ошибка <span style = "color: red;">4</span><span style = "color: blue;">0</span><span style = "color: red;">4</span>: страница не найдена.</h2>
<br>
<br>
<br>
<br>

<br>
<br>
<form><textarea rows="8" cols="60" style="border:none;overflow: hidden;background: #e9ecef00; font-family: 'Lobster', cursive; font-size: 1.2rem; width:100%"></textarea></form>
<br><br><br><br>
</blockquote>





</div></div>
<?php include 'inc/foot.php';?>
