<?php
include 'inc/head.php';
?>

<head>
  <title>Первые шаги</title>
</head>
<figure class="text-center">
  <blockquote class="blockquote">
    <p>Приветствую на сервисе учёта монтажей ArdMoney.</p>
  </blockquote>
  <figcaption class="blockquote-footer">
    Возможно самый важный калькулятор в твоей жизни :)
  </figcaption>
  <div class="alert alert-info" role="alert" style="padding: 0px 20px 0px;">
    <b>Если вы уже пользовались сервисом то просто нажмите на логотип</b>
  </div>
</figure>
<div class="card">
  <div class="card-body">
    <p>Ознакомьтесь с возможностями калькулятора с помощью двух тестовых аккаунтов:</p>
    <div class="container">
      <div class="row">
        <div class="col" style="width: 0%;">
          <div class="card" style="width: 10rem;">
            <div class="card-header">
              Администратор
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Логин - <b>test</b></li>
              <li class="list-group-item">Пароль - <b>test</b></li>
            </ul>
          </div>
        </div>
        <div class="col">
          <div class="card" style="width: 10rem;">
            <div class="card-header">
              Пользователь
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Логин - <b>test2</b></li>
              <li class="list-group-item">Пароль - <b>test2</b></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="d-grid gap-2">
      <a class="btn btn-outline-success btn-sm" href="/" role="button">Кнопка для авторизации</a>
    </div>
    <div class="alert alert-success" role="alert" style="padding: 0px 20px 0px;">
      <a href="ardmoney.apk" class="alert-link">Настоятельно рекомендую скачать приложение для Android <img src="img/android.png" style="width: 32px;padding-bottom: 18px;">ArdMoney</a>.
    </div>
  </div>
</div>
</div>
<?php ///низ сайта
include 'inc/foot.php';
?>