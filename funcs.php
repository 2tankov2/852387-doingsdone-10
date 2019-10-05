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
 * @return bool
 */
function isExpiringTask($date)
{
    return hoursDiff($date) <= 24;
}

/**
 * Получает id пользователя и ресурс соединения, возвращает массив с проектами пользователя
 * @param string $userId строка с id пользователя
 * @param object(mysqli) $link ресурс соединения
 * @return array ассоциативный массив с проектами выбранного пользователя
 */
function getProjects($userId, $link)
{
    $sql = "SELECT p.id, p.name, COUNT(t.id) AS tasks_count FROM projects p
    LEFT JOIN tasks t ON p.id = t.project_id
    WHERE p.user_id = '$userId' GROUP BY p.id ";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        die(mysqli_error($link));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * @param string $name название
 * @return string
 */
function getPostVal($name)
{
    return isset($_POST[$name]) ? strip_tags($_POST[$name]) : "";
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

    return ($len < $MIN_LENGTH) ? "Запишите название задачи" : null;
}

/**
 * валидация выбора названия проекта в форме
 * @param int $projectId идентификатор проекта
 * @param array $allowedList массив существующих идентификаторов проекта
 * @return  в случае, если переданное значение идентификатора не существует среди значений идентификаторов в массиве,
 * возвращается текст ошибки "Указан несуществующий проект",
 * иначе null
 */

function validateProjects($projectId, $allowedList)
{
    return (!in_array($projectId, $allowedList)) ? "Указан несуществующий проект" : null;
}

/**
 * @return bool
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
 * @return bool
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
        default:
            return $taskCompleteDate;
    }
}

/**
 * @param string $data название фильтра
 * @return bool
 */

function isFilterTask($data)
{
    return $_COOKIE['task_filter'] === $data;
}

/**
 * @return bool
 */

function isFilter()
{
    return !isset($_GET['task_filter']);
}

/**
 * @return bool
 */

function isSearch()
{
    return isset($_GET['q']);
}

/**
 * удаляет специальные HTML символы
 * @param string $text
 * @return string
*/

function deleteHtmlSpecialChars($text)
{
     return strip_tags($text);
}
