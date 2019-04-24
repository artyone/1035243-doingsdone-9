<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'functions/templates.php';
require_once 'functions/db.php';


$showCompleteTasks = rand(0, 1);
$user = getUser(dbConnect(), 2);
$categories = getCategories(dbConnect(), $user['id']);
$tasks = getTasks(dbConnect(), $user['id']);

$pageContent = includeTemplate('main.php', ['tasks' => $tasks, 'showCompleteTasks' => $showCompleteTasks]);
$layoutContent = includeTemplate('layout.php',
    [
        'pageContent' => $pageContent,
        'categories' => $categories,
        'title' => 'Дела в порядке - Главная',
        'userName' => $user['name'],
        'tasks' => $tasks
    ]
);

print($layoutContent);
