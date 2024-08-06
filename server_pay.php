<?php
include "inc/head.php";
AutorizeProtect();
access();
animate();
?>

<head>
  <title>Список домов</title>
</head>
<?
$month = date_view($_GET['date']);
$date_current = $_GET['date'];
if (!isset($_GET['date'])) {
  $month = month_view(date('m'));
  $date = date("Y-m-d");
  $date_current = substr($date, 0, -3);
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding: 0;">
  <div class="container-fluid" style="background: #00000070;">
    <a class="navbar-brand" href="#"></a>
    <div class="navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav rut_nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $month ?>
          </a>
          <?
          li_month();
          ?>
        </li>
        <?php
        if (!empty(htmlentities($_COOKIE['user']))) {
        ?>
          <ul style="float: right;">
            <li>
              <a href="user.php">
                <img src="/img/home.png" style="width: 40px;padding-bottom: 7px;">
              </a>
            </li>
          </ul>
        <?php
        } ?>
      </ul>
    </div>
  </div>
</nav>






<div class="container text-black">
  <div class="row justify-content-center">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Уважаемые пользователи,</h5>
        <p class="card-text">Хочу обратить ваше внимание на важное сообщение от меня, разработчика нашего приложения.</p>
        <p class="card-text">На ближайшем горизонте у нас назревает необходимость оплаты сервера для обеспечения надлежащей работы нашего приложения. Как многие из вас знают, цены на серверное обслуживание взлетели из-за недавних санкций.</p>
        <p class="card-text">Сумма, необходимая для оплаты сервера на следующий год, составляет 62,6 € или 6288 рублей. Понимаю, что не всегда легко выкроить средства на такие вещи, поэтому обращаюсь к вам с просьбой о помощи.</p>
        <p class="card-text">Оплата, конечно, добровольна, но она крайне желательна. Если у вас есть возможность поддержать наше приложение финансово, буду очень благодарен за любую сумму, которую вы сможете пожертвовать.</p>
        <p class="card-text">Для удобства, предоставляю ссылку для пожертвования либо переводом по номеру РНКБ или через СПБ.</p>
        <p class="card-text"><a href="https://www.tinkoff.ru/cf/AwmNLM8eFAA"><img src="img/tinkoff.png" width="32px">Ссылка для перевода</a></p>
        <p class="card-text"><img src="img/rnkb.png" width="32px">+79789458418</p>
        <p class="card-text">Если у вас возникнут вопросы или понадобится дополнительная информация, не стесняйтесь связаться со мной.</p>
        <p class="card-text">Благодарю вас за внимание и поддержку. С вашей помощью сможем продолжать делать наше приложение еще лучше!</p>
        <p class="card-text">С уважением,</p>
        <p class="card-text">Никита Техник района Москольцо</p>
      </div>
    </div>
  </div>
</div>


<?php
include 'inc/foot.php';
?>