<?php

$connection = connection($config['dbTest']);

$data = [
    [
        'name' => '',
        'project_id' => null,
        'expiration_date' => '192029'
    ],
    [
        'name' => 'afsdfsfsadfsfsafasfsfsasdfsdfasfsafasfsafsfsfsafsafsfsafasfsfsafasfsafasfsafsfsafasfasfsafasfasfasfasfasfasfasfasfsafasfsafasdfddfdfdfdsfafasfsdffdfdfdffasfsfsfasafasfsafasfasfasfsfsfsfasfasfasfasfsafsafsafasfsafsafsfsafsafasfasfasfsafsafsafasfasfsafasfasfsfasfasfsdfsadf',
        'project_id' => '222',
        'expiration_date' => '1990-03-10'
    ],
    [
        'name' => 'Name',
        'project_id' => '1',
        'expiration_date' => '2040-03-10'
    ],
    [
        'name' => 'Name',
        'project_id' => '1',
        'expiration_date' => '2020-03-10'
    ]
];

$expected = [
    [
        'name' => 'Заполните имя задачи',
        'project_id' => 'Заполните поле проекта',
        'expiration_date' => 'Введите корректный формат даты'
    ],
    [
        'name' => 'Имя задачи не должно превышать 255 символов',
        'project_id' => 'Выберите существующий проект',
        'expiration_date' => 'Дата должна быть не раньше текущей'
    ],
    [
        'expiration_date' => 'Дата не может быть больше 19 января 2038 года'
    ],
    [
    ]
];

for ($i = 0; $i < count($data); $i ++) {
    $result = validateTaskForm($connection, $data[$i], 1);
    if ($result !== $expected[$i]) {
        die('Тест функции validateTaskForm НЕ пройден! Функция вернула: ' . $i . var_dump($result));
    }
}

echo 'Тест функции validateTaskForm пройден.'.PHP_EOL;