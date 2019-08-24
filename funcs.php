<?php

function calculateTask($tasks, $project_id) {
    $result = 0;
    foreach ($tasks as $task) {
      if ($task['project_id'] === $project_id) {
        $result +=1;
      }
    }
    return $result;
  }

  function hoursDiff($completeDate) {
    $endTs = strtotime($completeDate);
    $secsToEndTask = $endTs - time();
    $hours = floor($secsToEndTask / 3600);
    return $hours;
  }

  function isExpiringTask($date) {
    return hoursDiff($date) <= 24 ? "task--important" : '';
  }
