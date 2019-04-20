# добавление данных в  таблицу задач
INSERT INTO doingdone.task (create_time, status, name, expiration_time, project_id, user_id)
VALUES ('2019-04-20 18:21:17', 0, 'Собеседование в IT компании', '2019-04-18', '3', '1');

INSERT INTO doingdone.task (create_time, status, name, expiration_time, project_id, user_id)
VALUES ('2019-04-20 18:21:17', 0, 'Выполнить тестовое задание', '2019-02-20', '3', '2');

INSERT INTO doingdone.task (create_time, status, name, expiration_time, project_id, user_id)
VALUES ('2019-04-20 18:21:17', 1, 'Сделать задание первого раздела', '2019-04-27', '2', '1');

INSERT INTO doingdone.task (create_time, status, name, expiration_time, project_id, user_id)
VALUES ('2019-04-19 18:21:17', 0, 'Встреча с другом', '2019-04-19', '1', '1');

INSERT INTO doingdone.task (create_time, status, name, expiration_time, project_id, user_id)
VALUES ('2019-04-20 18:21:17', 0, 'Купить корм для кота', null, '4', '2');

INSERT INTO doingdone.task (create_time, status, name, expiration_time, project_id, user_id)
VALUES ('2019-04-21 20:21:17', 0, 'Заказать пиццу', null, '4', '1');

# добавление данных в таблицу проектов
INSERT INTO doingdone.project (name, user_id)
VALUES ('Входящие', 1);

INSERT INTO doingdone.project (name, user_id)
VALUES ('Учеба', 1);

INSERT INTO doingdone.project (name, user_id)
VALUES ('Работа', 1);

INSERT INTO doingdone.project (name, user_id)
VALUES ('Домашние дела', 1);

INSERT INTO doingdone.project (name, user_id)
VALUES ('Авто', 1);

# добавление данных в таблицу пользователей
INSERT INTO doingdone.user (create_time, email, name, password)
VALUES ('2019-04-20 17:58:59', 'ex@mail.com', 'Артём Ти', 12344);

INSERT INTO doingdone.user (create_time, email, name, password)
VALUES ('2019-03-20 17:58:59', 'ee@mail.com', 'Иван Ил', 12343);


# получить список из всех проектов для одного пользователя
SELECT id, project_id, user_id FROM task WHERE user_id = 1;

#Объедините проекты с задачами, чтобы посчитать количество задач в каждом проекте и в дальнейшем выводить эту цифру рядом с именем проекта;
SELECT t.id, t.NAME, p.name FROM  task t JOIN project p ON t.project_id = p.id;

#получить список из всех задач для одного проекта;
SELECT id, name FROM task WHERE project_id = 2;

#пометить задачу как выполненную;
UPDATE task SET status = 1 WHERE name = 'Встреча с другом';

#обновить название задачи по её идентификатору.
UPDATE task SET NAME = 'Измененная задача' WHERE id = 1;