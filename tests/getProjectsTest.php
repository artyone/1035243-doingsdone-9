<?php

require_once '../functions/db.php';

$config = require_once '../config.php';
$connection = connection($config['dbTest']);

$project = [
    [
        'user_id' => 1,
        'expected' =>
            [
                ['id' => 1, 'name' => 'Входящие'],
                ['id' => 2, 'name' => 'Учеба'],
                ['id' => 3, 'name' => 'Работа'],
                ['id' => 4, 'name' => 'Домашние дела'],
                ['id' => 5, 'name' => 'Авто']
            ]
    ],
    [
        'user_id' => 2,
        'expected' =>
            [
                ['id' => 6, 'name' => 'Входящие'],
                ['id' => 7, 'name' => 'Учеба'],
                ['id' => 8, 'name' => 'Работа'],
                ['id' => 9, 'name' => 'Домашние дела']
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
        die('Тест не пройден!');
    }
}

print 'Тест функции getProjects пройден' . PHP_EOL;