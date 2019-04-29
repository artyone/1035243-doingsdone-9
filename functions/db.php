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
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Функия получения из БД пользователя по идентификатору
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @return array массив с данными идентификатора, имени и эл. почты
 */

function getUser(mysqli $connection, int $userId) : array
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
 * Функция получения задач для пользователя с отбором по идентификатору
 * @param int|mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @param int $projectId идентификатор проекта
 * @return array|null ассоциативный массив с данными идентификатора, статуса, имени, адреса файла, даты окончания
 * задачи и идентификатора категории
 */
function getTasks(mysqli $connection, int $userId, ?int $projectId) : array
{
    $sqlQuery = "SELECT id, status, name, file_link, DATE_FORMAT(expiration_time, '%d.%m.%Y') as expiration_time, 
       project_id FROM task WHERE user_id = ?" . (($projectId) ? "&& project_id = ?" : "");

    $array[0] = $userId;
    if ($projectId) {
        $array[1] = $projectId;
    }

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
 * Функция получения текущего проекта
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId уникатльный идентификатор пользователя
 * @param int $projectId идентификатор проекта
 * @return array массив с данными идентификатора и названия текущего проекта
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
 * Функция записи данных в массив подготовленным выражением
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param array $taskData массив данных для записи в таблицу task
 * @return int|null возвращает идентификатор записаной строки в таблице.
 */
function insertTask(mysqli $connection, array $taskData) : ?int
{
    $sqlQuery = "INSERT INTO task (name, file_link, expiration_time, user_id, project_id) 
        VALUES (?,?,?,?,?)";

    if (!$taskData['date']) {
        $taskData['date'] = null;
    }

    $stmt = db_get_prepare_stmt($connection, $sqlQuery, [$taskData['name'], $taskData['fileLink'],
        $taskData['date'], $taskData['userId'], $taskData['project']]);
    mysqli_stmt_execute($stmt);
    $resource = mysqli_insert_id($connection);
    return $resource;
}