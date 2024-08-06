<?php
include "inc/head.php";
AutorizeProtect();
access();
global $usr;
global $connect;
animate();
?>

<head>
  <title>Список домов</title>
</head>


<?
$month = date_view($_GET['date']);
$date_blyat = "$_GET[date]";
if (!isset($_GET['date'])) {
  $month = month_view(date('m'));
  $date = date("Y-m-d");
  $date_blyat = substr($date, 0, -3);
}


if ($_GET['status'] == "success") {
  alrt("Монтаж завершен и подвержден!", "success", "2");
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding: 0;">
  <div class="container-fluid" style="background: #00000070;">
    <a class="navbar-brand" href="#"></a>
    <div class="navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">

        <?php
        if (!empty(htmlentities($_COOKIE['user']))) {
        ?>

          <li>
            <a href="user.php">
              <i style="font-size: x-large;color: lawngreen;" class="bi bi-house-gear"></i> </a>
          </li>

        <?php
        } ?>
      </ul>
    </div>
  </div>
</nav>
</div>


<?php
include 'inc/foot.php';
?>