<?php

/**
 * Функция проверки полей в на странице добавления проекта
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId идентефикатор пользователя
 * @param array $projectData массив с данными для проверки
 * @return array возвращает массив с описанием ошибок
 */
function validateProjectForm(mysqli $connection, int $userId, array $projectData) : array
{
    $errors = [];
    if ($error = validateProjectName($connection, $userId, $projectData['name'])) {
        $errors['name'] = $error;
    }
    return $errors;
}

/**
 * Функция проверки корректности введенного имени
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param int $userId идентефикатор пользователя
 * @param string $name имя проекта
 * @return string|null возвращает текст ошибки, если она есть
 */
function validateProjectName(mysqli $connection, int $userId, string $name) : ?string
{
    if (empty($name)) {
        return 'Заполните имя';
    }
    if (mb_strlen($name) > 255) {
        return 'Имя не должно превышать 255 символов';
    }
    if (getProjectByName($connection, $userId, $name)) {
        return 'Проект с таким именем уже существует';
    }
    return null;
}