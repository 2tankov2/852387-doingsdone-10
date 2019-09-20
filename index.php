<?php

require_once('helpers.php');
require_once('funcs.php');
require_once('data.php');
require_once('init.php');

if (!$link) {
    die('Ошибка подключения к БД');
}

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];

    $sql = "SELECT p.id, p.name, COUNT(t.id) AS tasks_count FROM projects p
    LEFT JOIN tasks t ON p.id = t.project_id WHERE p.user_id = '$user_id' GROUP BY p.id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        die(mysqli_error($link));
    }

    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!isset($_GET['project_id']) && !isset($_GET['show_completed']) || !isset($_GET['project_id']) && $_GET['show_completed'] === '0') {

        $sql = "SELECT * FROM tasks WHERE user_id = '$user_id' AND state = 0";
        $result = mysqli_query($link, $sql);
        $checked = isset($_GET['show_completed']) ? $_GET['show_completed'] : '';

    } elseif (!isset($_GET['project_id']) && $_GET['show_completed'] === '1') {

        $checked = $_GET['show_completed'];
        $sql = "SELECT * FROM tasks WHERE user_id = '$user_id'";
        $result = mysqli_query($link, $sql);

    } elseif (isset($_GET['project_id'])) {

        $project_id = mysqli_real_escape_string($link, $_GET['project_id']);

        if (isset($_GET['show_completed']) && $_GET['show_completed'] === '1') {

            $checked = $_GET['show_completed'];
            $sql = "SELECT * FROM tasks WHERE project_id = '%s' AND user_id = '$user_id'";
            $sql = sprintf($sql, $project_id);

        } else {

            $checked = isset($_GET['show_completed']) ? $_GET['show_completed'] : '';
            $sql = "SELECT * FROM tasks WHERE project_id = '%s' AND user_id = '$user_id' AND state = 0";
            $sql = sprintf($sql, $project_id);

        }

        $result = mysqli_query($link, $sql);

        if (!$result) {
            die(mysqli_error($link));
        }
    }

    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (isset($_GET['check'])) {

        $task_id = $_GET['task_id'];

        $sql = "UPDATE tasks SET state = ?  WHERE id = ?";

        $state = $_GET['check'];
        $state === '0' ? '1' : '0';

        $stmt = db_get_prepare_stmt($link, $sql, [$state, $task_id]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            header("Location: /index.php");
            exit();

    }

    $tasks_content = include_template('list_tasks.php', [
        'task_list' => $tasks,
        'show_completed' => $checked,
        'show_complete_tasks' => $show_complete_tasks
    ]);

    if (isset($_GET['q'])) {
        $search = trim($_GET['q']) ?? '';

        if (!strlen($search)) {
            $tasks_content = include_template('list_tasks.php', [
                'search' => $search,
                'task_list' => [],
                'show_completed' => $checked,
                'show_complete_tasks' => $show_complete_tasks
                ]);
        }
        else {

            $sql = "SELECT * FROM tasks
                    WHERE user_id = '$id' AND MATCH(name) AGAINST(? IN BOOLEAN MODE)";

            $stmt = db_get_prepare_stmt($link, $sql, [$search]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        $tasks_content = include_template('list_tasks.php', [
            'search' => $search,
            'task_list' => $tasks,
            'show_completed' => $checked,
            'show_complete_tasks' => $show_complete_tasks
            ]);
    }

    $user = $_SESSION['user'];
    $user_name = $_SESSION['user']['name'];

    $page_content = include_template('main.php', [
        'content_main' => $tasks_content,
        'projects' => $projects
    ]);

    $layout_content = include_template('layout.php', [
        'user' => $user,
        'user_name' => $user_name,
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная страница'
    ]);
} else {
    $page_content = include_template('guest.php', []);

    $layout_content = include_template('layout.php', [
        'user' => [],
        'user_name' => '',
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная страница'
    ]);
}
print($layout_content);
