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
