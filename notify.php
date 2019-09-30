<?php

require_once 'vendor/autoload.php';
require_once 'helpers.php';
require_once 'funcs.php';
require_once 'init.php';

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$sql_tasks = "SELECT  t.name AS task_name, DATE_FORMAT(complete_date, '%d.%m.%Y') AS complete_date, u.name AS user_name, email
    FROM tasks t LEFT JOIN users u ON u.id = t.user_id WHERE complete_date = CURDATE() AND state = 0";
$result = mysqli_query($link, $sql_tasks);

if (!$result) {
    die(mysqli_error($link));
}

$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

$emails = array_unique(array_column($tasks, 'email'));

$user_name = '';
$task_name = '';
$complete_date = '';
$user_email = '';
$text = '';

foreach ($emails as $email) {
    $user_email = $email;
    $task_text = '';
    $count_tasks = 1;
    foreach ($tasks as $task) {
        if ($task['email'] === $user_email) {
            $user_name = $task['user_name'];
            $done_date = $task['complete_date'];

            $correct_textform = get_noun_plural_form($count_tasks, 'запланирована задача ', 'запланированы задачи: ', 'запланированы задачи: ');
            $task_text .= $task['task_name'] . '  на ' . $task['complete_date'] . '; ';
            $text = ' Уважаемый (ая),  ' . $task['user_name'] . '. У вас ' . $correct_textform . $task_text;
            $count_tasks++;
        }
    }

    $message = (new Swift_Message("Уведомление от сервиса «Дела в порядке»"))
        ->setFrom(['keks@phpdemo.ru' => '«Дела в порядке»'])
        ->setTo([$user_email => $user_name])
        ->setBody($text, 'text/plain');
    $result = $mailer->send($message);
    if ($result) {
        print("Рассылка успешно отправлена");
    } else {
        print("Не удалось отправить рассылку");
    }
}

