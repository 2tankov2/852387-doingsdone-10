<?php

require_once('helpers.php');
require_once('funcs.php');
require_once('data.php');
require_once('init.php');

if (!$link) {
    die('Ошибка подключения к БД');
}

$sql = 'SELECT * FROM projects WHERE user_id = 3';
$result = mysqli_query($link, $sql);

if (!$result) {
    $error = mysqli_error($link);
    die($error);
}

$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = 'SELECT * FROM tasks WHERE user_id = 3';

$res = mysqli_query($link, $sql);

if (!$res) {
    $error = mysqli_error($link);
    die($error);
}

$tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);

$page_content = include_template('main.php', [
    'projects' => $projects,
    'task_list' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Дела в порядке - Главная страница'
]);

print($layout_content);
