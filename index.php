<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'functions/templates.php';
require_once 'functions/db.php';
require_once 'functions/request.php';
$config = require_once 'config.php';

$showCompleteTasks = rand(0, 1);
$connection = connection($config['dbWork']);
$user = getUser($connection, 2);
$projects = getProjects($connection, $user['id']);
$tasks = getTasks($connection, $user['id'], unpackGet('project'));

$pageContent = includeTemplate('main.php', ['tasks' => $tasks, 'showCompleteTasks' => $showCompleteTasks]);
$layoutContent = includeTemplate('layout.php',
    [
        'pageContent' => $pageContent,
        'connection' => $connection,
        'projects' => $projects,
        'title' => 'Дела в порядке - Главная',
        'user' => $user,
        'tasks' => $tasks
    ]
);

print $layoutContent;
