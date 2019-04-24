<?php

require_once '../functions/db.php';

$connectDB = dbConnect('localhost', 'root', '123', 'doingdone_test');

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
    $result = getUser($connectDB, $value['id']);
    if ($result != $value['expected']) {
        var_dump(array_diff($result, $value['expected']));
        die('Тест не пройден!');
    }
}

print 'Тест функции getUser пройден' . PHP_EOL;
