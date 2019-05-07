<?php
function validateAuthForm(array $authData) : array
{
    $errors = [];
    if ($error = validateAuthPassword($authData['password'])) {
        $errors['password'] = $error;
    }
    if ($error = validateAuthEmail($authData['email'])) {
        $errors['email'] = $error;
    }
    return $errors;
}

function validateAuthEmail(string $email) : ?string
{
    if (empty($email)) {
        return 'Заполните e-mail адрес';
    }
    if (mb_strlen($email) > 500) {
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
 * @return string|null возврщает текст ошибки
 */
function validateAuthPassword(string $password) : ?string
{
    if (empty($password)) {
        return 'Заполните пароль';
    }
    if (mb_strlen($password) > 500) {
        return 'Пароль не должен превышать 255 символов';
    }
    return null;
}
