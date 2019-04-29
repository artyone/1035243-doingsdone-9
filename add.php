<?php

require_once 'bootstrap.php';
const UPLOAD_DIR = __DIR__ . '/uploads/';
$connection = connection($config['dbWork']);
$user = getUser($connection, 2);
$title = 'Добавление задачи';
$projects = getProjects($connection, $user['id']);

$taskData = [];
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskData = formDataFilter($_POST);
    $error = validateTaskForm($taskData, $connection, $user['id']);

    if (!$error) {
        $taskData['fileLink'] = uploadFile($_FILES['file'], UPLOAD_DIR);
        $taskData['userId'] = $user ['id'];
        if (insertTask($connection, $taskData)) {
            header('Location: ' . 'index.php');
            die();
        }
    }
}

$pageContent = includeTemplate('newTask.php', ['projects' => $projects, 'taskData' => $taskData, 'error' => $error]);
$layoutContent = includeTemplate('layout.php',
    [
        'pageContent' => $pageContent,
        'projects' => $projects,
        'title' => $title,
        'user' => $user
    ]
);

print $layoutContent;