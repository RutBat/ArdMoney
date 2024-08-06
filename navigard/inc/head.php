<?php
session_start();
include("inc/function.php");// Тут висят все функции сайта.
echo'<!doctype html>
<html lang="ru">
';

include("inc/style.php");// тег head в котором указываются все стили сайта
echo'<body style = "background: #ffffff url(img/bg.png) repeat;">';
echo'<div class="container-sm">';
//Если первый раз входим на сайт, то показываем анимацию загрузки
$gde = $_SERVER["REQUEST_URI"];/////////////////////////////////
if ($gde == "/") {
    preloader();
}//////////////////////////////////
include("inc/navbar.php");//Навигационный бар
?>
<main role="main">
  <div style="padding: 0 0;background: #4242421f;" class="jumbotron">
    <div class="col-md-8 col-sm-12  mx-auto">