<?php
require_once 'bootstrap.php';
$connection = connection($config['dbWork']);
$user = getUserById($connection, 1);
$title = 'Дела в порядке - Регистрация';

$userData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userData = formDataFilter($_POST);
    $errors = validateUserForm($connection, $userData);

    if (!$errors) {
        if (insertUser($connection, $userData)) {
            session_start();
            $_SESSION = getUserByEmail($connection, $userData['email']);
            header('Location: ' . 'index.php');
            die();
        }
    }
}

$pageContent = includeTemplate('register.php', ['userData' => $userData, 'errors' => $errors]);
$layoutContent = includeTemplate('unauth.php',
    [
        'pageContent' => $pageContent,
        'title' => $title,
    ]
);

print $layoutContent;