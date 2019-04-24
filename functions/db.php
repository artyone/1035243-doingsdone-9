<?php


/**
 * Функция подключения к базе данных
 * @param array $config массив с данными подключениями
 * @return false|mysqli результат выполненения функции mysqli_connect
 */
function connection($config)
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
 * Функция получения категорий для пользователя с отбором по идентификатору
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @return array ассоциативный массив с данными идентификатора и названия проекта
 */
function getProjects(mysqli $connection, int $userId) : array
{
    $sqlQuery = "SELECT id, name FROM project WHERE user_id = $userId";
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
 * @return array|null ассоциативный массив с данными идентификатора, статуса, имени, адреса файла, даты окончания
 * задачи и идентификатора категории
 */
function getTasks(mysqli $connection, int $userId) : array
{
    $sqlQuery = "SELECT id, status, name, file_link, DATE_FORMAT(expiration_time, '%d.%m.%Y') as expiration_time, 
       project_id FROM task WHERE user_id = $userId";
    $resource = mysqli_query($connection, $sqlQuery);
    $result = mysqli_fetch_all($resource, MYSQLI_ASSOC);
    if (!$result) {
        return [];
    }
    return $result;
}


/**
 * Функция подсчета количества задач по проекту для пользователя с помощью запроса из БД
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $projectId уникальный идентефикатор проекта из таблицы проектов
 * @param int $userId уникатльный идентификатор пользователя
 * @return array|null массив с количеством задач по проекту для пользователя
 */
function countProjects(mysqli $connection, int $projectId, int $userId) : array
{
    $sqlQuery = "SELECT count(*) as countProjects FROM task WHERE project_id = $projectId && user_id = $userId";
    $resource = mysqli_query($connection, $sqlQuery);
    $result = mysqli_fetch_assoc($resource);
    if (!$result) {
        return [];
    }
    return $result;
}