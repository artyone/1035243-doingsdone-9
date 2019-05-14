<?php
require_once 'bootstrap.php';
$connection = connection($config['dbWork']);
$title = 'Дела в порядке - Регистрация';

$user = getUserFromSession();
if ($user) {
    header('Location: ' . 'index.php');
    die();
}

$userData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userData = getUserData($_POST);
    $errors = validateUserForm($connection, $userData);

    if (!$errors) {
        if (insertUser($connection, $userData)) {
            $_SESSION['user'] = getUserByEmail($connection, $userData['email']);
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