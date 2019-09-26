<?php

const MIN_LENGTH = 1;

function hoursDiff($completeDate)
{
    $endTs = strtotime($completeDate);
    $secsToEndTask = $endTs - time();
    $hours = floor($secsToEndTask / 3600);
    return $hours;
}

function isExpiringTask($date)
{
    return hoursDiff($date) <= 24;
}

function getPostVal($name)
{
    return $_POST[$name] ?? "";
}

function validateDate($date)
{
    $currentDate = strtotime($date);
    if ($currentDate <= time()) {
        return "Укажите корректную дату выполнения задачи";
    }
    return null;
}

function validateLength($text, $MIN_LENGTH)
{
    $str = trim($text);
    $len = strlen($str);

    if ($len < $MIN_LENGTH) {
        return "Запишите название задачи";
    }

    return null;
}

function validateProjects($projectId, $allowed_list)
{
    $id = $projectId;

    if (!in_array($id, $allowed_list)) {
        return "Указан несуществующий проект";
    }

    return null;
}

function isShowCompletedTask()
{
    return $_COOKIE['show_complete_tasks'] === 1;
}

function change_date_format($date, $format)
{
    $new_date = date_create($date);
    return date_format($new_date, $format);
}

function endDate($taskCompleteDate)
{
    $day = $_COOKIE['task_filter'];
    switch ($day) {
        case "day":
            $date = change_date_format("now", 'Y-m-d');
            return $taskCompleteDate === $date;
        case "tomorrow":
            $date = change_date_format("tomorrow", 'Y-m-d');
            return $taskCompleteDate === $date;
        case "late":
            $date = change_date_format("now", 'Y-m-d');
            return $taskCompleteDate < $date;
    }
}

function isFilterTask($data)
{
    return $_COOKIE['task_filter'] === $data;
}

function isFilter()
{
    return empty($_GET['task_filter']);
}

function isSearch()
{
    return isset($_GET['q']);
}
