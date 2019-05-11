<?php

/**
 * Функция получения названий проектов и количества задач по ним для пользователя
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @return array ассоциативный массив с данными идентификатора, названия проекта и количеством задач по проекту
 */
function getProjects(mysqli $connection, int $userId) : array
{
    $sqlQuery = "SELECT p.id, p.name, COUNT(t.project_id) AS task_count FROM project p 
    LEFT JOIN task t ON t.project_id = p.id WHERE p.user_id = ? GROUP BY p.id ORDER BY p.id ASC";
    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$userId]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_stmt_get_result($stmt);
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
 * @return array массив с данными идентификаторов и названия текущего проекта
 */
function getProject(mysqli $connection, int $userId, int $projectId) : array
{
    $sqlQuery = "SELECT id, name, user_id FROM project WHERE user_id = ? && id = ?";
    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$userId, $projectId]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($resource);
    if (!$result) {
        return [];
    }
    return $result;
}

/**
 * Функция получения проекта по имени пользователя для проверки дубля при добавлении нового проекта
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @param string $name имя проекта
 * @return array массив с данными идентификаторов и названия текущего проекта
 */
function getProjectByName(mysqli $connection, int $userId, string $name) : array
{
    $sqlQuery = "SELECT id, name, user_id FROM project WHERE user_id = ? && name = ?";
    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$userId, $name]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($resource);
    if (!$result) {
        return [];
    }
    return $result;
}

function insertProject(mysqli $connection, array $projectData) : ?int
{
    $sqlQuery = "INSERT INTO project (name, user_id) VALUES (?,?)";
    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$projectData['name'], $projectData['user_id']]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_insert_id($connection);
    return $resource;
}