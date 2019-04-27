<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'functions/templates.php';
require_once 'functions/db.php';
require_once 'functions/get.php';
$config = require_once 'config.php';

$showCompleteTasks = rand(0, 1);
$connection = connection($config['dbWork']);
$user = getUser($connection, 1);
$title = ['name' => 'Все проекты'];
$projects = getProjects($connection, $user['id']);
$tasks = getTasks($connection, $user['id'], getParam($_GET,'projectId'));

$projectId =  getParam($_GET, 'projectId');
if ($projectId) {
    $project = getProject($connection, $user['id'], $projectId);
    $title = $project;
    if (!$project) {
        http_response_code(404);
        die;
    }
}

$pageContent = includeTemplate('main.php', ['tasks' => $tasks, 'showCompleteTasks' => $showCompleteTasks]);
$layoutContent = includeTemplate('layout.php',
    [
        'pageContent' => $pageContent,
        'connection' => $connection,
        'projects' => $projects,
        'title' => $title,
        'user' => $user,
        'tasks' => $tasks
    ]
);

print $layoutContent;
