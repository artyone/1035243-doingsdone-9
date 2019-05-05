<?php
require_once 'bootstrap.php';
const UPLOAD_DIR = __DIR__ . '/uploads/';
$connection = connection($config['dbWork']);
$user = getUserById($connection, 1);
$title = 'Дела в порядке - Регистрация';
$projects = getProjects($connection, $user['id']);

$userData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userData = formDataFilter($_POST);
    $errors = validateUserForm($connection, $userData);

    if (!$errors) {
        if (insertUser($connection, $userData)) {
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