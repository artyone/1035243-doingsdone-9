<?php
require_once 'bootstrap.php';
$connection = connection($config['dbWork']);
$title = 'Дела в порядке - Вход на сайт';

$authData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $authData = formDataFilter($_POST);
    $errors = validateAuthForm($authData);

    if (!$errors) {
        if (!$errors['error'] = login($connection, $authData)) {
            $_SESSION = getUserByEmail($connection, $authData['email']);
            header('Location: ' . 'index.php');
            die();
        }
    }
}

$pageContent = includeTemplate('authUser.php', ['authData' => $authData, 'errors' => $errors]);
$layoutContent = includeTemplate('unauth.php',
    [
        'pageContent' => $pageContent,
        'title' => $title,
    ]
);

print $layoutContent;