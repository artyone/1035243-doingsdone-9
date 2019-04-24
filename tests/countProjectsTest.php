<?php


require_once '../functions/templates.php';
require_once '../functions/db.php';

$connectDB = dbConnect('localhost', 'root', '123', 'doingdone_test');

$tasks = getTasks($connectDB, 1);

$nameTask = [
    [
        'id' => 1,
        'user_id' => 1,
        'name' => 'Входящие',
        'expected' => 1
    ],
    [
        'id' => 2,
        'user_id' => 1,
        'name' => 'Учёба',
        'expected' => 1
    ],
    [
        'id' => 3,
        'user_id' => 1,
        'name' => 'Работа',
        'expected' => 1
    ],
    [
        'id' => 4,
        'user_id' => 1,
        'name' => 'Домашение дела',
        'expected' => 1
    ],
    [
        'id' => 5,
        'user_id' => 1,
        'name' => 'Авто',
        'expected' => 0
    ],
    [
        'id' => 200000,
        'user_id' => 1,
        'name' => 'Проверка большого числа',
        'expected' => 0
    ],
    [
        'id' => 0.1,
        'user_id' => 1,
        'name' => 'Проверка числа с плавающей точкой',
        'expected' => 0
    ],
    [
        'id' => 0,
        'user_id' => 1,
        'name' => 'Проверка нуля',
        'expected' => 0
    ],
    [
        // тест не проходит потому что возвращенный массив из базы возвращает массив со строковыми значениеми
        'id' => '3',
        'user_id' => 1,
        'name' => 'Проверка строки',
        'expected' => 1
    ],
    [
        'id' => 6,
        'user_id' => 2,
        'name' => 'Входящие',
        'expected' => 0
    ],
    [
        'id' => 7,
        'user_id' => 2,
        'name' => 'Учёба',
        'expected' => 1
    ],
    [
        'id' => 8,
        'user_id' => 2,
        'name' => 'Работа',
        'expected' => 0
    ],
    [
        'id' => 9,
        'user_id' => 2,
        'name' => 'Домашение дела',
        'expected' => 1
    ],
    [
        'id' => 200000,
        'user_id' => 2,
        'name' => 'Проверка большого числа',
        'expected' => 0
    ],
    [
        'id' => 0,
        'user_id' => 2,
        'name' => 'Проверка нуля',
        'expected' => 0
    ]
];

foreach ($nameTask as $value) {
    $result = countProjects($connectDB, $value['id'], $value['user_id'])['countProjects'];
    if ($result != $value['expected']) {
        var_dump($value);
        die('Тест не пройден! Функция вернула: ' . $result);
    }
}

print 'Тест функции countProjects пройден' . PHP_EOL;

