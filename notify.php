<?php

require_once 'vendor/autoload.php';
require_once 'helpers.php';
require_once 'funcs.php';
require_once 'init.php';

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$sql_users = "SELECT u.id, u.name, u.email FROM tasks t
              LEFT JOIN users u ON u.id = t.user_id
              WHERE DATE(t.complete_date) = DATE(CURRENT_DATE()) AND t.state = 0";
$res_users = mysqli_query($link, $sql_users);

if ($res_users && mysqli_num_rows($res_users)) {
    $users = mysqli_fetch_all($res_users, MYSQLI_ASSOC);

    foreach ($users as $user) {
        $user_id = $user['id'];
        $recipients = array();
        $sql = "SELECT name, complete_date FROM tasks WHERE DATE(complete_date) = DATE(CURRENT_DATE()) AND state = 0 AND user_id='$user_id'";
        $res = mysqli_query($link, $sql);
        if ($res && mysqli_num_rows($res)) {
            $tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $recipients[$user['email']] = $user['name'];

            $message = new Swift_Message();
            $message->setSubject("Уведомление от сервиса «Дела в порядке»");
            $message->setFrom(['keks@phpdemo.ru']);
            $message->setBcc($recipients);
            $msg_content = "";
            $tasks_list = "";

            foreach ($tasks as $task) {
                $tasks_list .= $task['name'] . " на " . $task['complete_date'] . "  ";
            }

            $count_tasks = count($tasks);

            $msg_content .= "Уважаемый, " . $user['name'] . ". У вас "
                         . get_noun_plural_form($count_tasks, 'запланирована', 'запланированы', 'запланированы')
                         . " " . get_noun_plural_form($count_tasks, 'задачи', 'задачи', 'задачи') . ": " . $tasks_list;

            $message->setBody($msg_content, 'text/plain');

            $result = $mailer->send($message);

            if ($result) {
                print("Рассылка успешно отправлена");
            } else {
                print("Не удалось отправить рассылку");
            }
        }
        if (!$res) {
            die(mysqli_error($link));
        }
    }if (!$res_users) {
        die(mysqli_error($link));
    }
}
