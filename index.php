<?php

require_once 'bootstrap.php';

$showCompleteTasks = rand(0, 1);
$connection = connection($config['dbWork']);
session_start();

if (getParam($_GET, 'user') == 'exit') {
    exitSession();
}

if ($_SESSION) {

    $user = $_SESSION;

    $title = 'Все проекты';
    $projects = getProjects($connection, $user['id']);
    $tasks = getTasks($connection, $user['id'], getParam($_GET, 'projectId'));
    $projectId = getParam($_GET, 'projectId');

    if ($projectId) {
        $project = getProject($connection, $user['id'], $projectId);
        if (!$project) {
            http_response_code(404);
            die;
        }
        $title = $project['name'];
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

} else {
    $layoutContent = includeTemplate('guest.php', []);
}

print $layoutContent;
