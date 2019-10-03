<?php

require_once 'vendor/autoload.php';
require_once 'helpers.php';
require_once 'funcs.php';
require_once 'init.php';

$user_id = $_SESSION['user']['id'];

$project_ids = [];

$projects = getProjects($user_id, $link);
$project_ids = array_column($projects, 'id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST;

    $errors = [];

    $rules = [
        'name' => function () use ($task) {
            return validateLength($task['name'], MIN_LENGTH);
        },
        'project_id' => function () use ($task, $project_ids) {
            return validateProjects($task['project_id'], $project_ids);
        },
        'date' => function () {
            return is_date_valid('date');
        },
        'date' => function () use ($task) {
            if ($task['date'] !== '') {
                return validateDate($task['date']);
            }
        }
    ];

    foreach ($task as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }

    $errors = array_filter($errors);

    if (empty($errors) && isset($_FILES['file'])) {
        $file_name = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url  = '/uploads/' . $file_name;

        move_uploaded_file($tmp_name, $file_path . $file_name);
        $task['path'] = $file_name;
    }

    if (count($errors)) {
        $tasks_content = include_template(
            'add_task.php',
            [
            'task' => $task,
            'errors' => $errors,
            'projects' => $projects
            ]
        );
    } else {
        $sql = "INSERT INTO tasks (user_id, name, project_id, complete_date, file_url) VALUES ('$user_id', ?, ?, ?, ?)";
        $stmt = db_get_prepare_stmt($link, $sql, $task);
        $res = mysqli_stmt_execute($stmt);

        if (!$res) {
            die(mysqli_error($link));
        }

        header("Location: /index.php");
    }
} else {
    $tasks_content = include_template(
        'add_task.php',
        [
        'projects' => $projects
        ]
    );
}

$page_content = include_template(
    'main.php',
    [
    'projects' => $projects,
    'content_main' => $tasks_content
    ]
);

$layout_content = include_template(
    'layout.php',
    [
    'user' => $_SESSION['user'],
    'user_name' => $_SESSION['user']['name'],
    'content' => $page_content,
    'title' => 'Дела в порядке - Добавление задачи'
    ]
);

print($layout_content);
