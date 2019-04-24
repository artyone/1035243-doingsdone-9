<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'functions/templates.php';
require_once 'functions/db.php';


$showCompleteTasks = rand(0, 1);
$connectDB = dbConnect('localhost', 'root', '123', 'doingdone_work');
$user = getUser($connectDB, 1);
$projects = getProjects($connectDB, $user['id']);
$tasks = getTasks($connectDB, $user['id']);

$pageContent = includeTemplate('main.php', ['tasks' => $tasks, 'showCompleteTasks' => $showCompleteTasks]);
$layoutContent = includeTemplate('layout.php',
    [
        'pageContent' => $pageContent,
        'connectDB' => $connectDB,
        'projects' => $projects,
        'title' => 'Дела в порядке - Главная',
        'user' => $user,
        'tasks' => $tasks
    ]
);

print $layoutContent;
