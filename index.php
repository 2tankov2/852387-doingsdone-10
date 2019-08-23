<?php

require_once('helpers.php');
require_once('funcs.php');
require_once('data.php');
require_once('config.php');
require_once('init.php');

if (!$link) {
    print($error_content);
}
else {
    $sql = 'SELECT * FROM projects WHERE user_id = 3';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
        $error  = include_template(('layout.php'), [
            'content' => $content,
            'title' => 'Дела в порядке - Главная страница'
        ]);
        print($error);
    }

    $sql = 'SELECT * FROM tasks WHERE user_id = 3';

    if ($res = mysqli_query($link, $sql)) {
    $tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    else {
    $content = include_template('error.php', ['error' => mysqli_error($link)]);
    }
}

$page_content = include_template('main.php', [
    'projects' => $projects,
    'task_list' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Дела в порядке - Главная страница'
]);

$off_content = include_template(('layout.php'), [
    'content' => include_template('off.php'),
	'title' => 'Дела в порядке - Главная страница'
]);

$error_content  = include_template(('layout.php'), [
    'content' => include_template('error.php', [
        'error' => mysqli_connect_error()]),
	'title' => 'Дела в порядке - Главная страница'
]);

if ($config['enable']) {
	print($layout_content);
}
else {
	print($off_content);
}
