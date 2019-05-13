<?php

require_once 'bootstrap.php';

$connection = connection($config['dbWork']);

$user = getUserFromSession();
if (!$user) {
    header('Location: ' . 'auth.php');
    die();
}

$title = 'Добавление задачи';
$projects = getProjects($connection, $user['id']);

$taskData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $taskData = formDataFilter($_POST);
    $errors = validateTaskForm($connection, $taskData, $user['id']);

    if (!$errors) {
        $taskData['file_link'] = uploadFile($_FILES['file'], UPLOAD_DIR);
        $taskData['user_id'] = $user ['id'];
        if (insertTask($connection, $taskData)) {
            header('Location: ' . 'index.php');
            die();
        }
    }
}

$pageContent = includeTemplate('newTask.php', ['projects' => $projects, 'taskData' => $taskData, 'errors' => $errors]);
$layoutContent = includeTemplate('layout.php',
    [
        'pageContent' => $pageContent,
        'projects' => $projects,
        'title' => $title,
        'user' => $user
    ]
);

print $layoutContent;