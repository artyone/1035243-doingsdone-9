<?php

require_once 'bootstrap.php';

$connection = connection($config['dbWork']);
$user = getUser($connection, 2);
$title = 'Добавление задачи';
$projects = getProjects($connection, $user['id']);

$taskData = [];
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskData = formDataFilter($_POST);
    $error = validateTaskForm($taskData, $connection, $user);

    if (!$error) {
        $taskData['fileLink'] = uploadFile($_FILES['file'], __DIR__);
        $taskData['userId'] = $user ['id'];
        if (insertTask($connection, $taskData['name'], $taskData['fileLink'], $taskData['date'], $taskData['userId'], $taskData['project'])) {
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