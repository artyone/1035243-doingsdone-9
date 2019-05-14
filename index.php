<?php

require_once 'bootstrap.php';

$connection = connection($config['dbWork']);

$user = getUserFromSession();

if ($user) {

    $projectIdFromGet = getProjectIdFromGet($_GET);
    $showCompletedFromGet = getShowCompletedFromGet($_GET);
    $timeRangeFromGet = getTimeRangeFromGet($_GET);
    $searchFromGet = getSearchFromGet($_GET);
    $taskIdFromGet = getTaskIdFromGet($_GET);

    if ($taskIdFromGet && getTaskById($connection, $taskIdFromGet, $user['id'])) {
        updateTask($connection, $taskIdFromGet);
    }

    if ($projectIdFromGet) {
        $project = getProject($connection, $user['id'], $projectIdFromGet);
        if (!$project) {
            http_response_code(404);
            header("Location: pages/404.html");
            die;
        }
        $title = $project['name'];
    }

    $title = 'Все проекты';
    $projects = getProjects($connection, $user['id']);

    if ($searchFromGet) {
        $tasks = searchTasks($connection, $user['id'], $searchFromGet);
        $title = 'Результат поиска по запросу: ' . $searchFromGet;
    } else {
        $tasks = getTasks($connection, $user['id'], $projectIdFromGet, $showCompletedFromGet, $timeRangeFromGet);
    }

    $pageContent = includeTemplate('main.php',
        [
            'tasks' => $tasks,
            'projectIdFromGet' => $projectIdFromGet,
            'showCompletedFromGet' => $showCompletedFromGet,
            'timeRangeFromGet' => $timeRangeFromGet,
            'searchFromGet' => $searchFromGet
        ]);
    $layoutContent = includeTemplate('layout.php',
        [
            'pageContent' => $pageContent,
            'connection' => $connection,
            'projects' => $projects,
            'title' => $title,
            'user' => $user,
            'tasks' => $tasks,
            'projectIdFromGet' => $projectIdFromGet,
            'showCompletedFromGet' => $showCompletedFromGet,
            'timeRangeFromGet' => $timeRangeFromGet
        ]
    );

} else {
    $layoutContent = includeTemplate('guest.php', []);
}

print $layoutContent;
