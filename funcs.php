<?php

function hoursDiff($completeDate) {
    $endTs = strtotime($completeDate);
    $secsToEndTask = $endTs - time();
    $hours = floor($secsToEndTask / 3600);
    return $hours;
}

function isExpiringTask($date) {
    return hoursDiff($date) <= 24;
}
