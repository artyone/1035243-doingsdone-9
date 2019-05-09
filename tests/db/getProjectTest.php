<?php

$connection = connection($config['dbTest']);

$project = [
    [
        'user_id' => 1,
        'id' => 2,
        'expected' => ['id' => 2, 'name' => 'Учеба', 'user_id' => 1]
    ],
    [
        'user_id' => 2,
        'id' => 9,
        'expected' => ['id' => 9, 'name' => 'Домашние дела', 'user_id' => 2]
    ],
    [
        'user_id' => 1,
        'id' => 7,
        'expected' => []
    ],
    [
        'user_id' => 3,
        'id' => 1,
        'expected' => []
    ],
    [
        'user_id' => 0,
        'id' => 1,
        'expected' => []
    ],
    [
        'user_id' => 25,
        'id' => 25,
        'expected' => []
    ]
];

foreach ($project as $value) {
    $result = getProject($connection, $value['user_id'], $value['id']);
    if ($result != $value['expected']) {
        var_dump(array_diff($result, $value['expected']));
        die('Тест функции getProject НЕ пройден!');
    }
}

print 'Тест функции getProject пройден.' . PHP_EOL;