<?php

require_once('helpers.php');
require_once('funcs.php');
require_once('data.php');
require_once('init.php');

if (!$link) {
    die('Ошибка подключения к БД');
}

if (isset($_SESSION['user'])) {
    $id = $_SESSION['user']['id'];

    $sql = "SELECT p.id, p.name, COUNT(t.id) AS tasks_count FROM projects p
    LEFT JOIN tasks t ON p.id = t.project_id WHERE p.user_id = '$id' GROUP BY p.id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        die(mysqli_error($link));
    }

    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!isset($_GET['id'])) {
        $sql = "SELECT * FROM tasks WHERE user_id = '$id'";
        $res = mysqli_query($link, $sql);
    } else {
        $id_project = mysqli_real_escape_string($link, $_GET['id']);
        $sql = "SELECT * FROM tasks WHERE project_id = '%s' AND user_id = '$id'";
        $sql = sprintf($sql, $id_project);
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

    if (isset($_GET['q'])) {
        $search = trim($_GET['q']) ?? '';

        if (!strlen($search)) {
            $tasks_content = include_template('list_tasks.php', [
                'search' => $search,
                'task_list' => [],
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
            'show_complete_tasks' => $show_complete_tasks
            ]);
    }

    // if (isset($_GET['..'])) {

    //     $state = $_GET['show_completed'] === 1 ?? 0;
    //     $sql = "UPDATE tasks SET state = '$state' WHERE id = '$id_task'";
    //     $stmt = db_get_prepare_stmt($link, $sql, [$_GET['show_completed']]);
    //         mysqli_stmt_execute($stmt);
    //         $result = mysqli_stmt_get_result($stmt);

    //     if ($result) {
    //         header("Location: /index.php");
    //         exit();
    //     }
    // }

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
