<?php

require_once('helpers.php');
require_once('funcs.php');
require_once('data.php');
require_once('config.php');

$page_content = include_template('main.php', [
    'task_list' => $task_list,
    'show_complete_tasks' => $show_complete_tasks,
    'projects' => $projects
]);

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Дела в порядке - Главная страница'
]);

$off_content = include_template('off.php', [
    'error_msg' => "Сайт на техническом обслуживании",
    'title' => 'Дела в порядке - Главная страница'
]);

if ($config['enable']) {
	print($layout_content);
}
else {
	print($off_content);
}
