<?php

/**
 * Функция проверки полей в на странице аутентификации
 * @param array $authData массив с данными для проверки
 * @return array возвращает массив с описанием ошибок
 */
function validateAuthForm(array $authData) : array
{
    $errors = [];
    if ($error = validateAuthEmail($authData['email'])) {
        $errors['email'] = $error;
    }
    if ($error = validateAuthPassword($authData['password'])) {
        $errors['password'] = $error;
    }
    return $errors;
}

/**
 * Функция проверки поля эл. почты
 * @param string $email эл. почта
 * @return string|null возвращает текст ошибки, если она есть
 */
function validateAuthEmail(string $email) : ?string
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
    return null;
}

/**
 * Функция проверки корректности введенного пароля
 * @param string $password пароль
 * @return string|null возвращает текст ошибки, если она есть
 */
function validateAuthPassword(string $password) : ?string
{
    if (empty($password)) {
        return 'Заполните пароль';
    }
    if (mb_strlen($password) > 255) {
        return 'Пароль не должен превышать 255 символов';
    }
    return null;
}
