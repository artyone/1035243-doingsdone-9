<?php

require_once 'bootstrap.php';

$showCompleteTasks = getParam($_GET, 'showCompleted');
$connection = connection($config['dbWork']);

$user = getUserFromSession();


if ($user) {
    if (getParam($_GET, 'taskId') && getTaskById($connection, getParam($_GET, 'taskId'), $user['id'])) {
        updateTask($connection, getParam($_GET, 'taskId'));
    }

    $title = 'Все проекты';
    $projects = getProjects($connection, $user['id']);
    $tasks = getTasks($connection, $user['id'], getParam($_GET, 'projectId'), getParam($_GET, 'showCompleted'), getParam($_GET, 'timeRange'));
    $projectId = getParam($_GET, 'projectId');

    if ($projectId) {
        $project = getProject($connection, $user['id'], $projectId);
        if (!$project) {
            http_response_code(404);
            header("Location: pages/404.html");
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
