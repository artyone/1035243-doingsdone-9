<?php

$urlData = [
    [
        'projectId' => 1,
        'showCompleted' => 1,
        'timeRange' => 'today',
        'expected' => '/?projectId=1&showCompleted=1&timeRange=today'
    ],
    [
        'projectId' => null,
        'showCompleted' => 1,
        'timeRange' => 'today',
        'expected' => '/?showCompleted=1&timeRange=today'
    ],
    [
        'projectId' => null,
        'showCompleted' => null,
        'timeRange' => 'today',
        'expected' => '/?timeRange=today'
    ],
    [
        'projectId' => null,
        'showCompleted' => null,
        'timeRange' => null,
        'expected' => '/?'
    ]
];

foreach ($urlData as $value) {
    $result = buildProjectUrl($value['projectId'], $value['showCompleted'], $value['timeRange']);
    if ($result != $value['expected']) {
        print 'Функция выдала: ' . $result . PHP_EOL;
        die('Тест функции buildProjectUrl НЕ пройден!');
    }
}

print 'Тест функции buildProjectUrl пройден.' . PHP_EOL;
