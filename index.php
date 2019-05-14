<?php

require_once 'bootstrap.php';

$connection = connection($config['dbWork']);

$user = getUserFromSession();

if ($user) {

    $projectId = getProjectId($_GET);
    $showCompleted = getShowCompleted($_GET);
    $timeRange = getTimeRange($_GET);
    $search = getSearch($_GET);
    $taskId = getTaskId($_GET);

    if ($taskId && getTaskById($connection, $taskId, $user['id'])) {
        updateTask($connection, $taskId);
    }

    if ($projectId) {
        $project = getProject($connection, $user['id'], $projectId);
        if (!$project) {
            http_response_code(404);
            header("Location: pages/404.html");
            die;
        }
        $title = $project['name'];
    }

    $title = 'Все проекты';
    $projects = getProjects($connection, $user['id']);

    if ($search) {
        $tasks = searchTasks($connection, $user['id'], $search);
        $title = 'Результат поиска по запросу: ' . $search;
    } else {
        $tasks = getTasks($connection, $user['id'], $projectId, $showCompleted, $timeRange);
    }

    $pageContent = includeTemplate('main.php',
        [
            'tasks' => $tasks,
            'projectId' => $projectId,
            'showCompleted' => $showCompleted,
            'timeRange' => $timeRange,
            'search' => $search
        ]);
    $layoutContent = includeTemplate('layout.php',
        [
            'pageContent' => $pageContent,
            'connection' => $connection,
            'projects' => $projects,
            'title' => $title,
            'user' => $user,
            'tasks' => $tasks,
            'projectId' => $projectId,
            'showCompleted' => $showCompleted,
            'timeRange' => $timeRange
        ]
    );

} else {
    $layoutContent = includeTemplate('guest.php', []);
}

print $layoutContent;
