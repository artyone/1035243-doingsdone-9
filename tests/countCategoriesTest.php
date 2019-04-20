<?php

require_once '../functions/templates.php';

$tasks = [
    [
        'category' => 'Учеба'
    ],
    [
        'category' => 'Учеба'
    ],
    [
        'category' => 'Работа'
    ],
    [
        'category' => 'Дом'
    ]
];

$nameTask = [
    [
        'name' => 'Учеба',
        'expected' => 2
    ],
    [
        'name' => 'Работа',
        'expected' => 1
    ],
    [
        'name' => '',
        'expected' => 0
    ],
    [
        'name' => null,
        'expected' => 0
    ],
    [
        'name' => 5,
        'expected' => 0
    ]
];

foreach ($nameTask as $name) {
    $result = countCategories($tasks, $name['name']);
    if ($result !== $name['expected']) {
        var_dump($name);
        die('Функция вернула: ' . $result);
    }
}

echo 'Тест функции countCategories пройден' . PHP_EOL;