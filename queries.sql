INSERT INTO projects (name, user_id)
VALUES ('Входящие', '1'), ('Учеба', 2), ('Работа', 2), ('Домашние дела', 1), ('Авто', 2);

INSERT INTO users (email, name, password)
VALUES ('graf45@yandex.ru', 'Гриша', 'tom789'),
       ('kosmos9@mail.ru', 'Петр', 'privet');

INSERT INTO tasks (user_id, project_id, state, name, complete_date)
VALUES (2, 3, 0, 'Собеседование в IT компании', '01.12.2018'),
       (2, 3, 0, 'Выполнить тестовое задание', '25.12.2018'),
       (2, 2, 1, 'Сделать задание первого раздела', '21.12.2018'),
       (1, 1, 0, 'Встреча с другом', '22.12.2018'),
       (1, 4, 0, 'Купить корм для кота'),
       (1, 4, 0, 'Заказать пиццу');

SELECT * FROM projects WHERE user_id = 2;

SELECT * FROM tasks WHERE project_id = 1;

UPDATE tasks SET state = 1 WHERE id = 2;

UPDATE tasks SET name = 'Купить корм для собаки' WHERE id = 5;
