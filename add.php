<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'functions/templates.php';
require_once 'functions/db.php';
require_once 'functions/methods.php';
$config = require_once 'config.php';

$connection = connection($config['dbWork']);
$user = getUser($connection, 2);
$title = 'Добавление задачи';
$projects = getProjects($connection, $user['id']);

$post =[];
foreach ($_POST as $key => $value) {
    $post[$key] = inputCheck($value);
}

$error = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($post['name'])) {
        $error['name'] = 'Заполните название задачи';
    }
    if (!('id' === array_search($post['project'], getProject($connection, $user['id'], $post['project'])))) {
        $error['project'] = 'Выберите существующий проект';
    }
    if (!is_date_valid($post['date']) && !empty($post['date'])) {
        $error['date'] = 'Введите корректный формат даты';
    }
    if (((strtotime($post['date']) - time() <= -86400)) && !empty($post['date'])){
        $error['date'] = 'Дата должна быть не раньше текущей';
    }
    if (!$error) {
        $fileUrl = uploadFile($_FILES['file'], __DIR__);
        if ($result = insertTask($connection, $post['name'], $fileUrl, $post['date'], $user['id'], $post['project'])) {
            header('Location: ' . 'index.php');
            die();
        }
    }
}

$pageContent = includeTemplate('newTask.php', ['projects' => $projects, 'post' => $post, 'error' => $error]);
$layoutContent = includeTemplate('layout.php',
    [
        'pageContent' => $pageContent,
        'projects' => $projects,
        'title' => $title,
        'user' => $user
    ]
);

print $layoutContent;