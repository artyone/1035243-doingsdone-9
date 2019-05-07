<?php

function login(mysqli $connection, array $authData) : ?string
{
    if ($dbData = getUserByEmail($connection, $authData['email'])) {
        if (password_verify($authData['password'], $dbData['password'])) {
            return null;
        }
    }
    return 'E-mail адрес или пароль введены неверно';
}

function logout()
{
    $_SESSION = [];
    header('Location: ' . 'index.php');
    die();
}