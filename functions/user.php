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
    $_SESSION['user'] = [];
    header('Location: ' . 'index.php');
    die();
}

function getUserFromSession()
{
    if ($_SESSION['user']) {
        return $_SESSION['user'];
    } else {
        return [];
    }
}