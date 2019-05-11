<?php

/**
 * Функция получения задач для пользователя с отбором по идентификатору
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @param int $projectId идентификатор проекта
 * @return array|null ассоциативный массив с данными идентификатора, статуса, имени, адреса файла, даты окончания
 * задачи и идентификатора категории
 */
function getTasks(mysqli $connection, int $userId, ?int $projectId, ?int $showCompleted, ?string $timeRange) : ?array
{
    $sqlQuery = "SELECT id, status, name, file_link, DATE_FORMAT(expiration_time, '%d.%m.%Y') as expiration_time, 
       project_id FROM task";

    $criteria = buildCriteria($userId, $projectId, $showCompleted, $timeRange);

    $sqlQuery = addCriteriaToQuery($sqlQuery, $criteria);
    $array = buildArrayForPrepareStmt($criteria);

    $stmt = db_get_prepare_stmt($connection, $sqlQuery, $array);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($resource, MYSQLI_ASSOC);
    if (!$result) {
        return [];
    }
    return $result;
}

/**
 * Функция записи данных по задаче в базу данных подготовленным выражением
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param array $taskData массив данных для записи в таблицу task
 * @return int|null возвращает идентификатор записаной строки в таблице.
 */
function insertTask(mysqli $connection, array $taskData) : ?int
{
    $sqlQuery = "INSERT INTO task (name, file_link, expiration_time, user_id, project_id) 
        VALUES (?,?,?,?,?)";

    if (!$taskData['expiration_date']) {
        $taskData['expiration_date'] = null;
    }

    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$taskData['name'], $taskData['file_link'],
        $taskData['expiration_date'], $taskData['user_id'], $taskData['project_id']]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_insert_id($connection);
    return $resource;
}

function updateTask(mysqli $connection, int $taskId) : ?int
{
    $sqlQuery = "UPDATE task SET STATUS = IF(STATUS = 0, 1, 0) WHERE id = ?";
    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$taskId]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_insert_id($connection);
    return $resource;
}

function getTaskById(mysqli $connection,  int $taskId, int $userId) : ?array
{
    $sqlQuery = "SELECT id FROM task WHERE id = ? && user_id = ?";
    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$taskId, $userId]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($resource);
    if (!$result) {
        return [];
    }
    return $result;
}