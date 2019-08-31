<?php

const MIN_LENGTH = 1;

function hoursDiff($completeDate) {
    $endTs = strtotime($completeDate);
    $secsToEndTask = $endTs - time();
    $hours = floor($secsToEndTask / 3600);
    return $hours;
}

function isExpiringTask($date) {
    return hoursDiff($date) <= 24;
}

function getPostVal($name) {
    return $_POST[$name] ?? "";
}

function validateDate($date) {
    $currentDate = strtotime($date);
    if ($currentDate <= time()) {
        return "Укажите корректную дату выполнения задачи";
    }
    return null;
}

function validateLength($text, $MIN_LENGTH) {
    $str = trim($text);
    $len = strlen($str);

    if ($len < $MIN_LENGTH) {
        return "Запишите название задачи";
    }

    return null;
}

function validateProjects($projectId, $allowed_list) {
    $id = $projectId;

    if (!in_array($id, $allowed_list)) {
        return "Указан несуществующий проект";
    }

    return null;
}
