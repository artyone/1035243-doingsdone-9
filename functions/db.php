<?php

/**
 * Функция подключения к базе данных
 * @param array $config массив с данными подключениями
 * @return false|mysqli результат выполненения функции mysqli_connect
 */
function connection(array $config) : mysqli
{
    $connect = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
    if (!$connect) {
        print 'Ошибка при подключении к БД: ' . mysqli_connect_error();
        die();
    }
    mysqli_set_charset($connect, "utf8");
    return $connect;
}

/**
 * Функия получения из БД пользователя по идентификатору
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @return array массив с данными идентификатора, имени и эл. почты
 */
function getUser(mysqli $connection, int $userId) : array
{
    $sqlQuery = "SELECT id, name, email FROM user WHERE id = $userId";
    $resource = mysqli_query($connection, $sqlQuery);
    $result = mysqli_fetch_assoc($resource);
    if (!$result) {
        return [];
    }
    return $result;
}

/**
 * Функция получения названий проектов и количества задач по ним для пользователя
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @return array ассоциативный массив с данными идентификатора, названия проекта и количеством задач по проекту
 */
function getProjects(mysqli $connection, int $userId) : array
{
    $sqlQuery = "SELECT p.id, p.name, COUNT(t.project_id) AS task_count FROM project p 
    LEFT JOIN task t ON t.project_id = p.id WHERE p.user_id = $userId GROUP BY p.id ORDER BY p.id ASC";
    $resource = mysqli_query($connection, $sqlQuery);
    $result = mysqli_fetch_all($resource, MYSQLI_ASSOC);
    if (!$result) {
        return [];
    }
    return $result;
}

/**
 * Функция получения задач для пользователя с отбором по идентификатору
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @param int $projectID идентификатор проекта
 * @return array|null ассоциативный массив с данными идентификатора, статуса, имени, адреса файла, даты окончания
 * задачи и идентификатора категории
 */
function getTasks(mysqli $connection, int $userId, ?int $projectID) : array
{
    $sqlQuery = "SELECT id, status, name, file_link, DATE_FORMAT(expiration_time, '%d.%m.%Y') as expiration_time, 
       project_id FROM task WHERE user_id = $userId" . (($projectID) ? "&& project_id = $projectID" : "");
    $resource = mysqli_query($connection, $sqlQuery);
    $result = mysqli_fetch_all($resource, MYSQLI_ASSOC);
    if (!$result) {
        return [];
    }
    return $result;
}

/**
 * Функция получения текущего проекта
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @param int $projectId идентификатор проекта
 * @return array массив с данными идентификатора и названия текущего проекта
 */
function getProject(mysqli $connection, int $userId, int $projectId) : array
{
    $sqlQuery = "SELECT id, name, user_id FROM project WHERE user_id = $userId && id = $projectId";
    $resource = mysqli_query($connection, $sqlQuery);
    $result = mysqli_fetch_assoc($resource);
    if (!$result) {
        return [];
    }
    return $result;
}
