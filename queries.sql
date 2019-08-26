INSERT INTO projects (name, user_id)
VALUES ('Входящие', '1'), ('Учеба', 2), ('Работа', 2), ('Домашние дела', 1), ('Авто', 2);

INSERT INTO users (email, name, password)
VALUES ('graf45@yandex.ru', 'Гриша', 'tom789'),
       ('kosmos9@mail.ru', 'Петр', 'privet');

INSERT INTO tasks (user_id, project_id, state, name, complete_date)
VALUES (2, 3, 0, 'Собеседование в IT компании', '2018.12.01'),
       (2, 3, 0, 'Выполнить тестовое задание', '2018.12.25'),
       (2, 2, 1, 'Сделать задание первого раздела', '2018.12.21'),
       (1, 1, 0, 'Встреча с другом', '2018.12.22');


INSERT INTO tasks (user_id, project_id, state, name)
VALUES (1, 4, 0, 'Купить корм для кота'),
       (1, 4, 0, 'Заказать пиццу');

SELECT * FROM projects WHERE user_id = 2;

SELECT * FROM tasks WHERE project_id = 1;

UPDATE tasks SET state = 1 WHERE id = 2;

UPDATE tasks SET name = 'Купить корм для собаки' WHERE id = 5;

INSERT INTO projects (name, user_id)
VALUES ('Спорт', '3'), ('Учеба', 3), ('Прочее', 3), ('Домашние дела', 3), ('Авто', 3), ('Мечта', 3);

INSERT INTO users (email, name, password)
VALUES ('krot83@mail.ru', 'Лена', 'grot2206');

INSERT INTO tasks (user_id, project_id, state, name, complete_date)
VALUES (3, 10, 1, 'Помыть машину', '2019.08.23'),
       (3, 9, 0, 'Сходить в магазин за покупками на неделю', '2019.08.25'),
       (3, 9, 1, 'Прибраться в квартире', '2019.08.22'),
       (3, 7, 0, 'Узнать, есть ли вода на других планетах Солнечной системы?', '2019.08.23'),
       (3, 6, 0, 'Сходить на тренировку', '2019.08.23'),
       (3, 7, 0, 'Выбрать музыкальный инструмент и начать учиться на нём играть', '2019.09.03'),
       (3, 6, 0, 'Взять велосипед и прокатиться за город', '2019.08.25'),
       (3, 8, 0, 'Вспомнить своё последнее обещание и выполнить его', '2019.08.24');
