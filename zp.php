<?php
include "inc/head.php";
AutorizeProtect();
access();
global $usr;
global $connect;
animate();
?>


<?php


// Обработка формы при отправке
if (isset($_GET['dejurstva'])) {
    // Получение новых значений из формы
    $newDejurstva = $_GET["dejurstva"];

    // Получение имени текущего пользователя (замените на свой способ получения имени пользователя)
    $currentUserName = $_GET["fio"];

    // SQL-запрос для обновления значений в базе данных
    $sql = "UPDATE `user` SET `dejurstva` = '$newDejurstva'  WHERE `fio` = '$currentUserName'";

    if ($connect->query($sql) === TRUE) {
        alrt("Значения успешно обновлены.","success",4);
    } else {
        echo "Ошибка при обновлении значений: " . $connect->error;
    }
}
$cur_user = $connect->query("SELECT * FROM `user` WHERE `fio` = '" . $_GET['fio'] . "'");
if ($cur_user->num_rows != 0) {
    $cuser = $cur_user->fetch_array(MYSQLI_ASSOC);
    $currentDejurstva = $cuser['dejurstva'];
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding: 0;">
    <div class="container-fluid" style="background: #00000070;">
        <a class="navbar-brand" href="#"></a>
        <div class="navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav rut_nav">
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

<!-- Форма для обновления dejurstva -->
<div class="container mt-4">
  <form method="GET" action="zp.php?fio=<?=$_POST['fio']?>">
      <h4><?=$_GET['fio']?></h4>
      <div class="form-group">
      <input type="hidden" name="fio" value="<?php echo $_GET['fio']; ?>">

          <label for="dejurstva">Количество дежурств:</label>
          <input type="text" class="form-control" name="dejurstva" value="<?php echo $currentDejurstva; ?>">
      </div>
      <br>
      <div style="width: 100%;" class="btn-group" role="group" aria-label="Basic outlined example">
<button type="submit" class="btn btn-primary btn-lg green_button">Обновить</button>
</div>

  </form>
</div>

<?php
include 'inc/foot.php';
?>
