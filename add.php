<?php

require_once 'bootstrap.php';
const UPLOAD_DIR = __DIR__ . '/uploads/';
$connection = connection($config['dbWork']);
$user = getUser($connection, 1);
$title = 'Добавление задачи';
$projects = getProjects($connection, $user['id']);

$taskData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $taskData = formDataFilter($_POST);
    $errors = validateTaskForm($taskData, $connection, $user['id']);

    if (!$errors) {
        $taskData['fileLink'] = uploadFile($_FILES['file'], UPLOAD_DIR);
        $taskData['userId'] = $user ['id'];
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