<?php

$connection = connection($config['dbTest']);

$project = [
    [
        'user_id' => 1,
        'expected' =>
            [
                ['id' => 1, 'name' => 'Входящие', 'task_count' => 1],
                ['id' => 2, 'name' => 'Учеба', 'task_count' => 1],
                ['id' => 3, 'name' => 'Работа', 'task_count' => 1],
                ['id' => 4, 'name' => 'Домашние дела', 'task_count' => 1],
                ['id' => 5, 'name' => 'Авто', 'task_count' => 0]
            ]
    ],
    [
        'user_id' => 2,
        'expected' =>
            [
                ['id' => 6, 'name' => 'Входящие', 'task_count' => 0],
                ['id' => 7, 'name' => 'Учеба', 'task_count' => 1],
                ['id' => 8, 'name' => 'Работа', 'task_count' => 0],
                ['id' => 9, 'name' => 'Домашние дела', 'task_count' => 1]
            ]
    ],
    [
        'user_id' => 3,
        'expected' => []
    ],
    [
        'user_id' => 0,
        'expected' => []
    ]
];


foreach ($project as $value) {
    $result = getProjects($connection, $value['user_id']);
    if ($result != $value['expected']) {
        var_dump(array_diff($result, $value['expected']));
        die('Тест функции getProjects НЕ пройден!');
    }
}

print 'Тест функции getProjects пройден.' . PHP_EOL;