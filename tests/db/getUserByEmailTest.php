<?php

$connection = connection($config['dbTest']);

$user = [
    [
        'email' => 'ex@mail.com',
        'expected' => ['id' => 1, 'email' => 'ex@mail.com', 'password' => 12344, 'name' => 'Артём Ти']
    ],
    [
        'email' => 'ee@mail.com',
        'expected' => ['id' => 2, 'email' => 'ee@mail.com', 'password' => 12343, 'name' => 'Иван Ил']
    ],
    [
        'email' => 'fdf',
        'expected' => []
    ]
];


foreach ($user as $value) {
    $result = getUserByEmail($connection, $value['email']);
    if ($result != $value['expected']) {
        var_dump(array_diff($result, $value['expected']));
        die('Тест функции getByEmail НЕ пройден!');
    }
}

print 'Тест функции getByEmail пройден.' . PHP_EOL;
