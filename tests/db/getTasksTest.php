<?php

$connection = connection($config['dbTest']);

$task = [
    [
        'user_id' => 1,
        'project_id' => null,
        'expected' =>
            [
                ['id' => 1, 'status' => 0, 'name' => 'Собеседование в IT компании', 'file_link' => null, 'expiration_time' => '18.04.2019', 'project_id' => 3],
                ['id' => 3, 'status' => 1, 'name' => 'Сделать задание первого раздела', 'file_link' => null, 'expiration_time' => '27.04.2019', 'project_id' => 2],
                ['id' => 4, 'status' => 0, 'name' => 'Встреча с другом', 'file_link' => null, 'expiration_time' => '19.04.2019', 'project_id' => 1],
                ['id' => 6, 'status' => 0, 'name' => 'Заказать пиццу', 'file_link' => null, 'expiration_time' => null, 'project_id' => 4]
            ]
    ],
    [
        'user_id' => 1,
        'project_id' => 1,
        'expected' =>
            [
                ['id' => 4, 'status' => 0, 'name' => 'Встреча с другом', 'file_link' => null, 'expiration_time' => '19.04.2019', 'project_id' => 1]
            ]
    ],
    [
        'user_id' => 1,
        'project_id' => 5,
        'expected' => []
    ],
    [
        'user_id' => 2,
        'project_id' => null,
        'expected' =>
            [
                ['id' => 2, 'status' => 0, 'name' => 'Выполнить тестовое задание', 'file_link' => null, 'expiration_time' => '20.02.2019', 'project_id' => 7],
                ['id' => 5, 'status' => 0, 'name' => 'Купить корм для кота', 'file_link' => null, 'expiration_time' => null, 'project_id' => 9]
            ]
    ],
    [
        'user_id' => 3,
        'project_id' => null,
        'expected' => []
    ],
    [
        'user_id' => 0,
        'project_id' => null,
        'expected' => []
    ]
];


foreach ($task as $value) {
    $result = getTasks($connection, $value['user_id'], $value['project_id']);
    if ($result != $value['expected']) {
        var_dump($result);
        die('Тест функции getTasks НЕ пройден!');
    }
}

print 'Тест функции getTasks пройден.' . PHP_EOL;