<?php

$param = [
    [
        'array' => ['projectId' => 1, 'showCompleted' => 1, 'timeRange'=> 'today'],
        'key' => 'projectId',
        'expected' => 1
    ],
    [
        'array' => ['showCompleted' => 1, 'timeRange'=> 'today'],
        'key' => 'projectId',
        'expected' => null
    ],
    [
        'array' => ['timeRange'=> 'today'],
        'key' => 'timeRange',
        'expected' => 'today'
    ],
    [
        'array' => [],
        'key' => 'projectId',
        'expected' => null
    ]
];

foreach ($param as $value) {
    $result = getParam($value['array'], $value['key']);
    if ($result != $value['expected']) {
        print 'Функция выдала: ' . $result . ' массив: ' . $param['array'] . PHP_EOL;
        die('Тест функции getParam НЕ пройден!');
    }
}

print 'Тест функции getParam пройден.' . PHP_EOL;
