<?php

require_once('helpers.php');
require_once('funcs.php');
require_once('data.php');
require_once('init.php');

if (!$link) {
    die('Ошибка подключения к БД');
}

$sql = 'SELECT p.id, p.name, COUNT(t.id) AS tasks_count FROM projects p
LEFT JOIN tasks t ON p.id = t.project_id WHERE p.user_id = 3 GROUP BY p.id ';
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

$tasks_content = include_template('list_tasks.php', [
    'task_list' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$page_content = include_template('main.php', [
    'content_tasks' => $tasks_content,
    'projects' => $projects
]);

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Дела в порядке - Главная страница'
]);

print($layout_content);
