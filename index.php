<?php

require_once 'vendor/autoload.php';
require_once 'helpers.php';
require_once 'funcs.php';
require_once 'init.php';

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];

    $projects = getProjects($user_id, $link);

    if (!isset($_GET['project_id'])) {
        $sql = "SELECT * FROM tasks
                WHERE user_id = '$user_id'";

        $result_tasks = mysqli_query($link, $sql);
    } else {
        $project_id = mysqli_real_escape_string($link, $_GET['project_id']);
        $sql = "SELECT * FROM tasks
                WHERE project_id = '%s' AND user_id = '$user_id'";

        $sql = sprintf($sql, $project_id);
        $result_tasks = mysqli_query($link, $sql);
        if (!$result_tasks) {
            die(mysqli_error($link));
        }
    }

    if (isset($_GET['task_filter'])) {
        $task_filter = trim($_GET['task_filter']) ?? null;
        if ($task_filter !== null) {
            setcookie("task_filter", '',  time() + 3600000);
            $_COOKIE['task_filter'] = $task_filter;
        }
    }

    if (isset($_GET['show_completed'])) {
        $show_completed = intval($_GET['show_completed']) ?? null;
        if ($show_completed !== null) {
            setcookie("show_complete_tasks", 0, time() + 3600000);
            $_COOKIE['show_complete_tasks'] = $show_completed;
        }
    }

    if (isset($_GET['check']) && isset($_GET['task_id'])) {
        $task_id = $_GET['task_id'];
        $is_checked = $_GET['check'];

        $sql = "UPDATE tasks SET state = ?
                WHERE id = ?";

        $stmt = db_get_prepare_stmt($link, $sql, [$is_checked, $task_id]);
        mysqli_stmt_execute($stmt);
        $result_tasks = mysqli_stmt_get_result($stmt);

        header("Location: /index.php");
        exit();
    }

    if (isset($_GET['q'])) {
        $search = trim($_GET['q']) ?? '';

        $sql = "SELECT * FROM tasks
                WHERE user_id = '$user_id' AND MATCH(name) AGAINST(? IN BOOLEAN MODE)";

        $stmt = db_get_prepare_stmt($link, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result_tasks = mysqli_stmt_get_result($stmt);
    }

    $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

    $tasks_content = include_template(
        'list_tasks.php',
        [
        'task_list' => $tasks
        ]
    );

    $page_content = include_template(
        'main.php',
        [
        'content_main' => $tasks_content,
        'projects' => $projects
        ]
    );

    $layout_content = include_template(
        'layout.php',
        [
        'user' => $_SESSION['user'],
        'user_name' => $_SESSION['user']['name'],
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная страница'
        ]
    );
} else {
    $page_content = include_template('guest.php', []);

    $layout_content = include_template(
        'layout.php',
        [
        'user' => [],
        'user_name' => '',
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная страница'
        ]
    );
}
print($layout_content);
