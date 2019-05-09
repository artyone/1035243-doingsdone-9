<?php
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
    if (mb_strlen($name) > 255) {
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
        return 'Заполните e-mail адрес';
    }
    if (mb_strlen($email) > 255) {
        return 'E-mail адрес не должен превышать 255 символов';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Указан некорректный e-mail адрес';
    }
    if (getUserByEmail($connection, $email)) {
        return 'Указанный e-mail адрес занят';
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
    if (mb_strlen($password) > 255) {
        return 'Пароль не должен превышать 255 символов';
    }
    return null;
}
