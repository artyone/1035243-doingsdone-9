<?php

require_once '../functions/templates.php';
require_once '../functions/db.php';

$connectDB = dbConnect('localhost', 'root', '123', 'doingdone_test');

$tasks = getTasks($connectDB, 1);

$nameTask = [
    [
        'id' => 1,
        'name' => 'Входящие',
        'expected' => 0
    ],
    [
        'id' => 2,
        'name' => 'Учёба',
        'expected' => 2
    ],
    [
        'id' => 3,
        'name' => 'Работа',
        'expected' => 1
    ],
    [
        'id' => 4,
        'name' => 'Домашение дела',
        'expected' => 1
    ],
    [
        'id' => 5,
        'name' => 'Авто',
        'expected' => 0
    ],
    [
        'id' => 200000,
        'name' => 'Проверка большого числа',
        'expected' => 0
    ],
    [
        'id' => 0.1,
        'name' => 'Проверка дробного числа',
        'expected' => 0
    ],
    [
        // тест не проходит потому что возвращенный массив из базы возвращает массив со строковыми значениеми
        'id' => '3',
        'name' => 'Проверка строки',
        'expected' => 0
    ]
];

foreach ($nameTask as $name) {
    $result = countProjects($tasks, $name['id']);
    if ($result !== $name['expected']) {
        var_dump($name);
        die('Тест не пройден! Функция вернула: ' . $result);
    }
}

print 'Тест функции countProjects пройден' . PHP_EOL;

