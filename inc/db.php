<?php


const HOST = "localhost";
const USER = "root";
const BAZA = "ardmoney";
const PASS = "root";

global $connect;
$connect = new mysqli(HOST, USER, PASS, BAZA);
$connect->query("SET NAMES 'utf8' ");
