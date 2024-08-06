<?php


const HOST = "localhost";
const USER = "ardmoney";
const BAZA = "ardmoney";
const PASS = "64ihufoz";

global $connect;
$connect = new mysqli(HOST, USER, PASS, BAZA);
$connect->query("SET NAMES 'utf8' ");
