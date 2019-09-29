<?php

date_default_timezone_set('Europe/Moscow');
const MIN_LENGTH = 1;

/**
 *  функция расчета разницы времени в часах между заданной датой и текущим временем
 * @param string $completeDate заданная дата
 * @return int $hours разница во времени в часах
*/
function hoursDiff($completeDate)
{
    $endTs = strtotime($completeDate);
    $secsToEndTask = $endTs - time();
    $hours = floor($secsToEndTask / 3600);
    return $hours;
}

/**
 * функция проверяет, истекает ли срок выполнения задачи
 * @return bool true если до окончания срока задачи менее 24 часов, иначе false
 */
function isExpiringTask($date)
{
    return hoursDiff($date) <= 24;
}

/**
 * возвращает данные из POST
 * @param string $name название
 * @return string если данные есть в POST - они возвращаются, иначе вернётся пустая строка
 */
function getPostVal($name)
{
    return $_POST[$name] ?? "";
}

/**
 * валидация даты в форме
 * @param string $date дата
 * @return в случае, если дата меньше текущей возвращается текст ошибки "Укажите корректную дату выполнения задачи",
 * иначе null
 */
function validateDate($currentDate)
{
    if ($currentDate < date('Y-m-d')) {
        return "Укажите корректную дату выполнения задачи";
    }
    return null;
}

/**
 * валидация длины названия задачи в форме
 * @param string $text текст, название задачи
 * @param int $MIN_LENGTH константа, название задачи должно состоять не менее чем из 1-го символа
 * @return  в случае, если название задачи состоит из менее 1 символа или пробелов,
 * возвращается текст ошибки "Запишите название задачи",
 * иначе null
 */

function validateLength($text, $MIN_LENGTH)
{
    $str = trim($text);
    $len = strlen($str);

    if ($len < $MIN_LENGTH) {
        return "Запишите название задачи";
    }

    return null;
}

/**
 * * валидация выбора названия проекта в форме
 * @param int $projectId идентификатор проекта
 * @param array $allowedList массив существующих идентификаторов проекта
 * @return  в случае, если переданное значение идентификатора не существует среди значений идентификаторов в массиве,
 * возвращается текст ошибки "Указан несуществующий проект",
 * иначе null
 */

function validateProjects($projectId, $allowedList)
{
    $id = $projectId;

    if (!in_array($id, $allowedList)) {
        return "Указан несуществующий проект";
    }

    return null;
}

/**
 * проверяет данные из COOKIE
 * @return bool true если данные есть в COOKIE и равны 1, иначе false
 */

function isShowCompletedTask()
{
    return $_COOKIE['show_complete_tasks'] === 1;
}

/**
 * приводит формат даты к нужному формату
 * @param string $date дата
 * @param string $format  нужный формат
 * @return false|string дата в нужном формате
 */

function changeDateFormat($date, $format)
{
    $new_date = date_create($date);
    return date_format($new_date, $format);
}

/**
 * определяет какие даты нужно возвращать по каждому фильтру
 * @param string $taskCompleteDate дата завершения задачи
 * @return bool true or false
 */

function endDate($taskCompleteDate)
{
    $day = $_COOKIE['task_filter'];
    switch ($day) {
        case "day":
            $date = changeDateFormat("now", 'Y-m-d');
            return $taskCompleteDate === $date;
        case "tomorrow":
            $date = changeDateFormat("tomorrow", 'Y-m-d');
            return $taskCompleteDate === $date;
        case "late":
            $date = changeDateFormat("now", 'Y-m-d');
            return $taskCompleteDate < $date;
    }
}

/**
 * проверяет данные из COOKIE
 * @param string $data название фильтра
 * @return bool true если название фильтра соответствует названию данных из COOKIE, иначе false
 */

function isFilterTask($data)
{
    return $_COOKIE['task_filter'] === $data;
}

/**
 * проверяет данные из GET
 * @return bool true если нет данных из фильтров, иначе false
 */

function isFilter()
{
    return empty($_GET['task_filter']);
}

/**
 * проверяет данные из GET
 * @return bool true если в строке поиска есть данные, иначе false
 */

function isSearch()
{
    return isset($_GET['q']);
}
