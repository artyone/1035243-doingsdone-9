<?php


function buildProjectUrl($projectId, $showCompleted, $timeRange)
{
    $urlData = [];

    if ($projectId) {
        $urlData['projectId'] = $projectId;
    }

    if ($showCompleted) {
        $urlData['showCompleted'] = $showCompleted;
    }

    if ($timeRange) {
        $urlData['timeRange'] = $timeRange;
    }

    return '/?' . http_build_query($urlData);
}

function getParam ($array, $key, $default = null)
{
    return $array[$key] ?? $default;
}