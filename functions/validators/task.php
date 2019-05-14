<?php
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
    if ($error = validateTaskProject($connection, $userId, ($taskData['project_id']))) {
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
    if (mb_strlen($name) > 255) {
        return 'Имя задачи не должно превышать 255 символов';
    }
    return null;
}

/**
 * Функция проверки существования выбранного проекта на форме
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId идентификатор пользователя
 * @param int|null $projectId идентификатор проекта
 * @return string|null возвращает текст ошибки
 */
function validateTaskProject(mysqli $connection, int $userId, ?int $projectId) : ?string
{
    if (!($projectId)) {
        return 'Заполните поле проекта';
    } elseif (!getProject($connection, $userId, $projectId)) {
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
