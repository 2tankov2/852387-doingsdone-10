<?php
require_once('init.php');
require_once('funcs.php');
require_once('helpers.php');

$tpl_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $errors = [];

    $req_fields = ['email', 'password', 'name'];

    foreach ($req_fields as $field) {
        if (empty(trim($form[$field]))) {
            $errors[$field] = "Не заполнено поле " . $field;
        }
    }

    $errors['email'] = filter_var($form['email'], FILTER_VALIDATE_EMAIL) ? null : 'Введите корректный email';

    $errors = array_filter($errors);

    if (empty($errors)) {
        $email = mysqli_real_escape_string($link, $form['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (email, name, password) VALUES (?, ?, ?)';
            $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], $password]);
            $res = mysqli_stmt_execute($stmt);
        }
        if ($res && empty($errors)) {
            header("Location: /index.php");
            exit();
        }

    }

    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $form;
}

$page_content = include_template('form_register.php', $tpl_data);

$layout_content = include_template('layout.php', [
    'content'    => $page_content,
    'title'      => 'Дела в порядке | Регистрация'
]);

print($layout_content);
