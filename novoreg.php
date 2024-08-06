<?php
include('inc/head.php');
access();
AutorizeProtect();
global $connect;
global $usr;

$current_date = date('y-m-d');

$access = $usr['access_date'];
$current_date = strtotime($current_date);
$access = strtotime($access);


?>

<div class="card">

  <div class="card-body">
    <p class="card-text">Месячная подписка стоит <b>200р/мес.</b> Все деньги будут уходить в оплату хостинга и кофе.</p>
    <hr>
    <h5>Как оплатить?</h5>
    <br>
    <p class="card-text">Можно скинуть на любую из карт прямым переводом или по номеру телефона через СБП:</p>
    <img src="img/sbp.png" alt="" width="48px"> <b>+7(978)945-84-18</b><br>
    <img src="img/rnkb.png" alt="" width="48px"><b>РНКБ 2200 0202 2350 3329</b><br>
    <a href="https://www.tinkoff.ru/cf/AwmNLM8eFAA"><img src="img/tinkoff.png" alt="" width="48px"><b style="color: black;">Tinkoff(ссылка)</a> 2200 7004 9478 7426</b><br>
    <hr>
    <p class="card-text">После оплаты обязательно напишите любым удобным для вас способом администратору:</p>
    <p class="card-text">Пример текста:</p>
    <p class="fst-italic"><b>Оплатил подписку доступа в приложение ArdMoney, оплачивал через РНКБ в <? echo date('y-m-d h:m'); ?>, моё Ф.И.О. <?= $usr['fio']; ?></b></p>
    <a href="https://wa.me/79789458418?text=Привет! Я оплатил подписку ArdMoney. Проверь пожалуйста. Меня зовут - <?= $usr['fio']; ?>"><img src="img/whatsapp.png" alt="" width="100px"></a><br><br>
    <a href="https://rutbat.t.me"><img src="img/telegram.png" alt="" width="100px"></a><br><br>
    <a href="httpd://rutbat.t.me"><img src="img/vk.png" alt="" width="100px"></a><br><br>
    <a href="tel:79789458418"><img src="img/sms.png" alt="" width="42px">+7(978)945-84-18</a><br>
    <br>
    После того как пройдет оплата администратор продлит доступ. Имейте терпение продление в ручном режиме.
    <br><br><br>
  </div>
</div>
<?
include('foot.php');
exit;
