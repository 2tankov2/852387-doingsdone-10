<?php

require_once 'vendor/autoload.php';
require_once 'init.php';
require_once 'funcs.php';
require_once 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $errors = [];

    $required = ['email', 'password'];

    foreach ($required as $field) {
        if (empty(trim($form[$field]))) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    $errors['email'] = filter_var($form['email'], FILTER_VALIDATE_EMAIL) ? null : 'Введите корректный email';

    $errors = array_filter($errors);


    $email = mysqli_real_escape_string($link, $form['email']);
    $sql = "SELECT * FROM users
            WHERE email = '$email'";

    $res = mysqli_query($link, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) && $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $page_content = include_template(
            'auth.php',
            [
            'form' => $form,
            'errors' => $errors
            ]
        );
    } else {
        header("Location: /index.php");
        exit();
    }
} else {
    $page_content = include_template('auth.php', []);

    if (isset($_SESSION['user'])) {
        header("Location: /index.php");
        exit();
    }
}

$layout_content = include_template(
    'layout.php',
    [
    'content'    => $page_content,
    'title'      => 'Дела в порядке'
    ]
);

print($layout_content);
