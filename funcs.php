<?php

function calculateTask($tasks, $nameProject) {
    $result = 0;
    foreach ($tasks as $task) {
      if ($task['category'] === $nameProject) {
        $result +=1;
      }
    }
    return $result;
  }

  function hoursDiff($completeDate)
  {
    $ts = time();
    $endTs = strtotime($completeDate);
    $secsToEndTask = $endTs - $ts;
    $hours = floor($secsToEndTask / 3600);
    return $hours;
  }
