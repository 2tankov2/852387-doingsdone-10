<?php

require_once 'vendor/autoload.php';
require_once 'helpers.php';
require_once 'funcs.php';
require_once 'init.php';


if (!$link) {
    die('Ошибка подключения к БД');
}

$id = $_SESSION['user']['id'];

$sql = "SELECT p.id, p.name, COUNT(t.id) AS tasks_count FROM projects p
LEFT JOIN tasks t ON p.id = t.project_id WHERE p.user_id = '$id' GROUP BY p.id ";
$result = mysqli_query($link, $sql);

if (!$result) {
    die(mysqli_error($link));
}

$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

$tpl_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project = $_POST;

    $errors = [];

    if (empty(trim($project['name']))) {
        $errors['name'] = 'Это поле надо заполнить';
    }

    $errors = array_filter($errors);

    if (empty($errors)) {
        $project_name = mysqli_real_escape_string($link, $project['name']);
        $sql = "SELECT user_id, name FROM projects WHERE name = '$project_name' AND user_id = '$id'";
        $res = mysqli_query($link, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['name'] = 'Проект с таким названием уже существует';
        } else {
            $sql = "INSERT INTO projects (name, user_id) VALUES (?, '$id')";
            $stmt = db_get_prepare_stmt($link, $sql, [$project['name']]);
            $res = mysqli_stmt_execute($stmt);
        }
        if ($res && empty($errors)) {
            header("Location: /index.php");
            exit();
        }
    }
    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $project;
}

$user = $_SESSION['user'];
$user_name = $_SESSION['user']['name'];

$project_content = include_template('add_project.php', $tpl_data);

$page_content = include_template(
    'main.php',
    [
    'projects' => $projects,
    'content_main' => $project_content
    ]
);

$layout_content = include_template(
    'layout.php',
    [
    'user' => $user,
    'user_name' => $user_name,
    'content' => $page_content,
    'title' => 'Дела в порядке - Добавление проекта'
    ]
);

print($layout_content);
