<?php

/**
 * Проверяет важна ли задача (до окончания меньше суток)
 * @param string $date дата выполнения задачи
 * @param bool $status факт выполнение задачи
 * @return bool
 */

function isImportant(?string $date, bool $status) : bool
{
    if ($status) {
        return false;
    }
    if (!$date) {
        return false;
    }
    if (strtotime($date) - time() >= 86400) {
        return false;
    }
    return true;
}

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'. Функция предоставлена академией
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Функция преобразования символов и удаления пробелов
 * @param array $data массив данных (из $_POST) требующий преобразований
 * @return array массив без пробелов в начале и конце строк с преобразованными символами
 */
function formDataFilter(array $data) : array
{
    $resultData = [];
    foreach ($data as $key => $value) {
        $resultData[$key] = trim($value);
        $resultData[$key] = htmlspecialchars($resultData[$key]);
    }
    return $resultData;
}

/**
 * Функция проверки заполнения полей из форм страницы добавления задачи
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param array $taskData массив с данными для проверки
 * @param int $userId уникальный идентификатор пользователя
 * @return array возвращает массив с описанием ошибок
 */
function validateTaskForm(mysqli $connection, array $taskData, int $userId) : array
{
    $errors = [];
    if ($error = validateTaskName($taskData['name'])) {
        $errors['name'] = $error;
    }
    if ($error = validateTaskProject($connection, $userId, $taskData['project_id'])) {
        $errors['project_id'] = $error;
    }
    if ($error = validateTaskDate($taskData['expiration_date'])) {
        $errors['expiration_date'] = $error;
    }
    return $errors;
}

/**
 * Функция проверки заполненности имени и длины строки задачи на форме
 * @param string $name имя задачи
 * @return string|null возвращает текст ошибки
 */
function validateTaskName(string $name) : ?string
{
    if (empty($name)) {
        return 'Заполните имя задачи';
    }
    if (mb_strlen($name) > 500) {
        return 'Имя задачи не должно превышать 255 символов';
    }
    return null;
}

/**
 * Функция проверки существования выбранного проекта на форме
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId идентификатор пользователя
 * @param int $projectId идентификатор проекта
 * @return string|null возвращает текст ошибки
 */
function validateTaskProject(mysqli $connection, int $userId, int $projectId) : ?string
{
    if (!getProject($connection, $userId, $projectId)) {
        return 'Выберите существующий проект';
    }
    return null;
}

/**
 * Функция проверки корректности введенной даты на форме
 * @param string $date дата
 * @return string|null возврщает текст ошибки
 */
function validateTaskDate(string $date) : ?string
{

    if (!is_date_valid($date) && !empty($date)) {
        return 'Введите корректный формат даты';
    }
    if ((strtotime($date) - time() <= -86400) && !empty($date)) {
        return 'Дата должна быть не раньше текущей';
    }
    if ($date > '2038-01-19') {
        return 'Дата не может быть больше 19 января 2038 года';
    }
    return null;
}

/**
 * Функция проверки и переименования загружаемого файла
 * @param string $name имя загружаемого файла
 * @param string $dir директория в которую файл будет сохранен
 * @return string возвращает новое имя файла, если текущее занято
 */
function validateFileName(string $name, string $dir) : string
{
    $name = substr(pathinfo($name , PATHINFO_FILENAME), 0, 20) . '.' . pathinfo($name, PATHINFO_EXTENSION);
    $newName = $name;

    $count = 0;
    while (file_exists($dir . $newName)) {
        $newName = pathinfo($name , PATHINFO_FILENAME) . $count . '.' . pathinfo($name, PATHINFO_EXTENSION);
        $count++;
    }
    return $newName;
}

/**
 * Функция проверки заполнения полей и корректности их заполнения из форм страницы регистрации пользователя
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param array $userData массив с данными для проверки
 * @return array возвращает массив с описанием ошибок
 */
function validateUserForm(mysqli $connection, array $userData) : array
{
    $errors = [];
    if ($error = validateUserName($userData['name'])) {
        $errors['name'] = $error;
    }
    if ($error = validateUserEmail($connection, $userData['email'])) {
        $errors['email'] = $error;
    }
    if ($error = validateUserPassword($userData['password'])) {
        $errors['password'] = $error;
    }
    return $errors;
}

/**
 * Функция проверки корректности введенного имени на форме
 * @param string $name имя
 * @return string|null возврщает текст ошибки
 */
function validateUserName(string $name) : ?string
{
    if (empty($name)) {
        return 'Заполните имя';
    }
    if (mb_strlen($name) > 500) {
        return 'Имя не должно превышать 255 символов';
    }
    return null;
}

/**
 * Функция проверки корректности введенной эл. почтына форме
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param string $email эл. почта
 * @return string|null возврщает текст ошибки
 */
function validateUserEmail(mysqli $connection, string $email) : ?string
{
    if (empty($email)) {
        return 'Заполните имя';
    }
    if (mb_strlen($email) > 500) {
        return 'E-mail адрес не должен превышать 255 символов';
    }
    if (getUserByEmail($connection, $email)) {
        return 'Указанный адрес e-mail занят';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Указан некорректный адрес e-mail';
    }
    return null;
}

/**
 * Функция проверки корректности введенного пароля
 * @param string $password пароль
 * @return string|null возврщает текст ошибки
 */
function validateUserPassword(string $password) : ?string
{
    if (empty($password)) {
        return 'Заполните пароль';
    }
    if (mb_strlen($password) > 500) {
        return 'Пароль не должен превышать 255 символов';
    }
    return null;
}