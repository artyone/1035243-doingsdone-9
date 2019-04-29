<?php

require_once '../functions/db.php';
$config = require'../config.php';

$connection = connection($config['dbTest']);

$user = [
    [
        'id' => 1,
        'expected' => ['id' => 1, 'name' => 'Артём Ти', 'email' => 'ex@mail.com']
    ],
    [
        'id' => 2,
        'expected' => ['id' => 2, 'name' => 'Иван Ил', 'email' => 'ee@mail.com']
    ],
    [
        'id' => 3,
        'expected' => []
    ],
    [
        'id' => 0,
        'expected' => []
    ]
];


foreach ($user as $value) {
    $result = getUser($connection, $value['id']);
    if ($result != $value['expected']) {
        //var_dump($value);
        var_dump(array_diff($result, $value['expected']));
        die('Тест функции getUser НЕ пройден!');
    }
}

print 'Тест функции getUser пройден.' . PHP_EOL;
