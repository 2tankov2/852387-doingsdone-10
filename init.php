<?php

session_start();

$link = mysqli_connect('localhost', 'root', 'M12g04R11l03!', 'doingsdone');
mysqli_set_charset($link, "utf8");

if (!$link) {
    die('Ошибка подключения к БД');
}
