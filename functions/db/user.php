<?php
/**
 * Функия получения из БД пользователя по идентификатору
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @return array массив с данными идентификатора, имени и эл. почты
 */

function getUserById(mysqli $connection, int $userId) : array
{
    $sqlQuery = "SELECT id, name, email FROM user WHERE id = ?";
    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$userId]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($resource);
    if (!$result) {
        return [];
    }
    return $result;
}

/**
 * Функция получения пользователя из базы данных по эл. почте
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param string $email эл. почта
 * @return array возвращает массив с данными по пользователю, если нашлось совпадение по эл. почте
 */
function getUserByEmail(mysqli $connection, string $email) : array
{
    $sqlQuery = "SELECT id, email, password, name FROM user WHERE email = ?";
    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$email]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($resource);
    if (!$result) {
        return [];
    }
    return $result;
}

/**
 * Функция записи данных по пользователю в базу данных подготовленным выражением
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param array $userData массив данных для записи в таблицу user
 * @return int|null возвращает идентификатор записаной строки в таблице
 */
function insertUser(mysqli $connection, array $userData) : ?int
{
    $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
    $sqlQuery = "INSERT INTO user (email, password, name) VALUES (?,?,?)";

    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$userData['email'], $userData['password'], $userData['name']]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_insert_id($connection);
    return $resource;
}

