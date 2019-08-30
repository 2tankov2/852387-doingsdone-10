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
    $currentDate = strtotime($_POST[$date]);
    if ($currentDate <= time()) {
        return "Укажите корректную дату выполнения задачи";
    }
    return null;
}

function validateLength($name, $MIN_LENGTH) {
    $str = trim($_POST[$name]);
    $len = strlen($str);

    if ($len < $MIN_LENGTH) {
        return "Запишите название задачи";
    }

    return null;
}

function validateProjects($name, $allowed_list) {
    $id = $_POST[$name];

    if (!in_array($id, $allowed_list)) {
        return "Указан несуществующий проект";
    }

    return null;
}
