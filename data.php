<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$projects = ['Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];
$task_list = [
    [
        'nameTask' => 'Собеседование в IT компании',
        'completeDate' => '01.12.2018',
        'category' => 'Работа',
        'state' => 'Нет'
    ],
    [
        'nameTask' => 'Выполнить тестовое задание',
        'completeDate' => '25.12.2018',
        'category' => 'Работа',
        'state' => 'Нет'
    ],
    [
        'nameTask' => 'Сделать задание первого раздела',
        'completeDate' => '21.12.2018',
        'category' => 'Учеба',
        'state' => 'Да'
    ],
    [
        'nameTask' => 'Встреча с другом',
        'completeDate' => '22.12.2018',
        'category' => 'Входящие',
        'state' => 'Нет'
    ],
    [
        'nameTask' => 'Купить корм для кота',
        'completeDate' => 'Нет',
        'category' => 'Домашние дела',
        'state' => 'Нет'
    ],
    [
        'nameTask' => 'Заказать пиццу',
        'completeDate' => 'Нет',
        'category' => 'Домашние дела',
        'state' => 'Нет'
    ]
];
