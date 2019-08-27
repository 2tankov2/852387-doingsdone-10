<?php

require_once('helpers.php');
require_once('funcs.php');
require_once('data.php');
require_once('init.php');

if (!$link) {
    die('Ошибка подключения к БД');
}

$sql = 'SELECT p.id, p.name, p.user_id, COUNT(t.id) AS tasks_count FROM projects p
LEFT JOIN tasks t ON p.id = t.project_id WHERE t.user_id = 3 GROUP BY t.project_id ';
$result = mysqli_query($link, $sql);

if (!$result) {
    die(mysqli_error($link));
}

$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (!isset($_GET['id'])) {
    $sql = 'SELECT * FROM tasks WHERE user_id = 3';
    $res = mysqli_query($link, $sql);
} else {
    $id = mysqli_real_escape_string($link, $_GET['id']);
    $sql = "SELECT * FROM tasks WHERE project_id = '%s' AND user_id = 3";
    $sql = sprintf($sql, $id);
    $res = mysqli_query($link, $sql);

    if (!$res) {
        die(mysqli_error($link));
    }

    if (!mysqli_num_rows($res)) {
        http_response_code(404);
        die();
    }
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
