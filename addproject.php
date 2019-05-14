<?php

require_once 'bootstrap.php';

$connection = connection($config['dbWork']);

$user = getUserFromSession();
if (!$user) {
    header('Location: ' . 'auth.php');
    die();
}

$title = 'Добавление проекта';
$projects = getProjects($connection, $user['id']);

$projectData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $projectData = getProjectData($_POST);
    $errors = validateProjectForm($connection, $user['id'], $projectData);

    if (!$errors) {
        $projectData['user_id'] = $user['id'];
        if (insertProject($connection, $projectData)) {
            header('Location: ' . 'index.php');
            die();
        }
    }
}

$pageContent = includeTemplate('newProject.php', ['projectData' => $projectData, 'errors' => $errors]);
$layoutContent = includeTemplate('layout.php',
    [
        'pageContent' => $pageContent,
        'projects' => $projects,
        'title' => $title,
        'user' => $user
    ]
);

print $layoutContent;