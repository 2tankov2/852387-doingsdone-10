insert into projects (name, user_id)
values ('Входящие', '1'), ('Учеба', 2), ('Работа', 2), ('Домашние дела', 1), ('Авто', 2);

insert into users (date_add, email, name, password)
values (NOW(), 'graf45@yandex.ru', 'Гриша', 'tom789'),
       (NOW(), 'kosmos9@mail.ru', 'Петр', 'privet');

insert into tasks (user_id, project_id, date_add, state, name, complete_date)
values (2, 3, NOW(), 0, 'Собеседование в IT компании', '01.12.2018'),
       (2, 3, NOW(), 0, 'Выполнить тестовое задание', '25.12.2018'),
       (2, 2, NOW(), 1, 'Сделать задание первого раздела', '21.12.2018'),
       (1, 1, NOW(), 0, 'Встреча с другом', '22.12.2018'),
       (1, 4, NOW(), 0, 'Купить корм для кота'),
       (1, 4, NOW(), 0, 'Заказать пиццу');

select * from projects where user_id = 2;

select * from tasks where user_id = 1;

UPDATE tasks SET state = 1 WHERE id = 2;

UPDATE tasks SET name = 'Купить корм для собаки' WHERE id = 5;
