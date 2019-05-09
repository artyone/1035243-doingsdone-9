<?php

/**
 * Функция для входа на сайт, которая проверяет существует ли комбинация эл. почта
 * @param mysqli $connection результат выполнения функции подключения к БД
 * @param array $authData массив с данными для входа
 * @return string|null возвращает ошибку, если комбинация не найдена
 */
function login(mysqli $connection, array $authData) : ?string
{
    if ($dbData = getUserByEmail($connection, $authData['email'])) {
        if (password_verify($authData['password'], $dbData['password'])) {
            return null;
        }
    }
    return 'E-mail адрес или пароль введены неверно';
}

/**
 * Функция выхода из учетной записи пользователя
 */
function logout()
{
    unset($_SESSION['user']);
    header('Location: ' . 'index.php');
    die();
}

/**
 * Функция получения пользователя из массива сессии
 * @return array|mixed возвращает данные пользователя или пустой массив
 */
function getUserFromSession()
{
    return $_SESSION['user'] ?? [];
}