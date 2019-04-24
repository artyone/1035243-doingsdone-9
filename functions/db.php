<?php

/**
 * Функция подключения к базе данных
 * @param string $adress адрес
 * @param string $login логин
 * @param string $password пароль
 * @param string $nameDB имя БД
 * @return false|int|mysqli
 */
function dbConnect($adress, $login, $password, $nameDB)
{
    $connect = mysqli_connect($adress, $login, $password, $nameDB);
    if (!$connect) {
        return print('no connection');
    }
    mysqli_set_charset($connect, "utf8");
    return $connect;
}

/**
 * Функия получения из БД пользователя по идентификатору
 * @param int|mysqli $connectDB результат выполнения функции подключения к БД
 * @param int $user_id уникатльный идентификатор пользователя
 * @return array|null массив с данными идентификатора, имени и эл. почты
 */
function getUser($connectDB, $user_id)
{
    $sqlQuery = "SELECT id, name, email FROM user WHERE id = " . $user_id;
    $resource = mysqli_query($connectDB, $sqlQuery);
    $result = mysqli_fetch_assoc($resource);
    return $result;
}

/**
 * Функция получения категорий для пользователя с отбором по идентификатору
 * @param int|mysqli $connectDB результат выполнения функции подключения к БД
 * @param int $user_id уникатльный идентификатор пользователя
 * @return array|null ассоциативный массив с данными идентификатора и названия проекта
 */
function getProjects($connectDB, $user_id)
{
    $sqlQuery = "SELECT id, name FROM project WHERE user_id = " . $user_id;
    $resource = mysqli_query($connectDB, $sqlQuery);
    $result = mysqli_fetch_all($resource, MYSQLI_ASSOC);
    return $result;
}

/**
 * Функция получения задач для пользователя с отбором по идентификатору
 * @param int|mysqli $connectDB результат выполнения функции подключения к БД
 * @param string $user_id уникатльный идентификатор пользователя
 * @return array|null ассоциативный массив с данными идентификатора, статуса, имени, адреса файла, даты окончания
 * задачи и идентификатора категории
 */
function getTasks($connectDB, $user_id)
{
    $sqlQuery = "SELECT id, status, name, file_link, DATE_FORMAT(expiration_time, '%d.%m.%Y') as expiration_time, 
       project_id FROM task WHERE user_id = " . $user_id;
    $resource = mysqli_query($connectDB, $sqlQuery);
    $result = mysqli_fetch_all($resource, MYSQLI_ASSOC);
    return $result;
}


/**
 * Функция подсчета количества задач по проекту для пользователя с помощью запроса из БД
 * @param int|mysqli $connectDB результат выполнения функции подключения к БД
 * @param int $id уникальный идентефикатор проекта из таблицы проектов
 * @param int $user_id уникатльный идентификатор пользователя
 * @return array|null массив с количеством задач по проекту для пользователя
 */
function countProjects($connectDB, $id, $user_id)
{
    $sqlQuery = "SELECT count(*) as countProjects FROM task WHERE project_id = " . $id  . " && user_id = ". $user_id;
    $resource = mysqli_query($connectDB, $sqlQuery);
    $result = mysqli_fetch_assoc($resource);
    return $result;
}