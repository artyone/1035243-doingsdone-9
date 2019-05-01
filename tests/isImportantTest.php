<?php
require '../functions/validators.php';

$tasks = [
    [
        'date' => (new DateTime())->format('d.m.Y'),
        'status' => false,
        'expected' => true
    ],
    [
        'date' => (new DateTime())->modify('+1 day')->format('d.m.Y'),
        'status' => false,
        'expected' => true
    ],
    [
        'date' => (new DateTime())->modify('+2 day')->format('d.m.Y'),
        'status' => false,
        'expected' => false
    ],
    [
        'date' => (new DateTime())->modify('-1 day')->format('d.m.Y'),
        'status' => false,
        'expected' => true
    ],
    [
        'date' => (new DateTime())->format('d.m.Y'),
        'status' => true,
        'expected' => false
    ],
    [
        'date' => null,
        'status' => false,
        'expected' => false
    ]
];

foreach ($tasks as $task) {
    $result = isImportant($task['date'], $task['status']);
    if ($result !== $task['expected']) {
        var_dump($task);
        die('Тест функции isImportant НЕ пройден! Функция вернула: '.$result);
    }
}

echo 'Тест функции isImportant пройден.'.PHP_EOL;