<?php
session_start();
include("inc/function.php"); // Тут висят все функции сайта.
echo '<!doctype html><html lang="ru">';
include("inc/style.php"); // тег head в котором указываются все стили сайта
echo '<body style = "background: #ffffff url(img/background.webp) repeat;">';
echo '<div class="container-sm">';
include("inc/navbar.php"); //Навигационный бар
?>
<main role="main">
    <div style="min-height: calc(100vh - 9rem);padding: 0 0;    background: #fff;
" class="jumbotron">
        <div class="col-md-12 col-sm-12  mx-auto">