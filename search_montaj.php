<?php
include "inc/head.php";
AutorizeProtect();
access();
animate();
?>

<head>
    <title>Поиск монтажей</title>
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
<script src="https://cdn.jsdelivr.net/mark.js/7.0.0/jquery.mark.min.js"></script>

<div class="input-group">
    <span class="input-group-text">Поиск</span>
    <input id="spterm" type="text" aria-label="адрес" class="form-control" oninput="searchMontaj()">
</div>
<div id="context">
<figure class="text-center">
  <blockquote class="blockquote">
    <p>В поле поиска пишите любой адрес где монтажили и сможете посмотреть кто, когда и какие выполнял работы по данному адресу
</p>
  </blockquote>
</figure>
</div>

<script>
function searchMontaj() {
    let searchTerm = document.getElementById("spterm").value;
    
    if (searchTerm.length >= 2) {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "obr_search_montaj.php?query=" + encodeURIComponent(searchTerm), true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("context").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    } else {
        document.getElementById("context").innerHTML = '';
    }
}
</script>

<?php
include 'inc/foot.php';
?>
