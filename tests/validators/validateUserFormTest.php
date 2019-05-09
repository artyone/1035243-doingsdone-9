<?php

$connection = connection($config['dbTest']);

$data = [
    [
        'name' => '',
        'email' => '',
        'password' => ''
    ],
    [
        'name' => 'afsdfsfsadfsfsafasfsfsasdfsdfasfsafasfsafsfsfsafsafsfsafasfsfsafasfsafasfsafsfsafasfasfsafasfasfasfasfasfasfasfasfsafasfsafasdfddfdfdfdsfafasfsdffdfdfdffasfsfsfasafasfsafasfasfasfsfsfsfasfasfasfasfsafsafsafasfsafsafsfsafsafasfasfasfsafsafsafasfasfsafasfasfsfasfasfsdfsadf',
        'email' => 'afsdfsfsadfsfsafasfsfsasdfsdfasfsafasfsafsfsfsafsafsfsafasfsfsafasfsafasfsafsfsafasfasfsafasfasfasfasfasfasfasfasfsafasfsafasdfddfdfdfdsfafasfsdffdfdfdffasfsfsfasafasfsafasfasfasfsfsfsfasfasfasfasfsafsafsafasfsafsafsfsafsafasfasfasfsafsafsafasfasfsafasfasfsfasfasfsdfsadf',
        'password' => 'afsdfsfsadfsfsafasfsfsasdfsdfasfsafasfsafsfsfsafsafsfsafasfsfsafasfsafasfsafsfsafasfasfsafasfasfasfasfasfasfasfasfsafasfsafasdfddfdfdfdsfafasfsdffdfdfdffasfsfsfasafasfsafasfasfasfsfsfsfasfasfasfasfsafsafsafasfsafsafsfsafsafasfasfasfsafsafsafasfasfsafasfasfsfasfasfsdfsadf'
    ],
    [
        'name' => 'Name',
        'email' => 'sdfsdfsf',
        'password' => 'password'
    ],
    [
        'name' => 'Name',
        'email' => 'ex@mail.com',
        'password' => 'password'
    ],
    [
        'name' => 'Name',
        'email' => '1@mail.com',
        'password' => 'password'
    ]
];

$expected = [
    [
        'name' => 'Заполните имя',
        'email' => 'Заполните e-mail адрес',
        'password' => 'Заполните пароль'
    ],
    [
        'name' => 'Имя не должно превышать 255 символов',
        'email' => 'E-mail адрес не должен превышать 255 символов',
        'password' => 'Пароль не должен превышать 255 символов'
    ],
    [
        'email' => 'Указан некорректный e-mail адрес',
    ],
    [
        'email' => 'Указанный e-mail адрес занят',
    ],
    [
    ]
];

for ($i = 0; $i < count($data); $i++) {
    $result = validateUserForm($connection, $data[$i]);
    if ($result !== $expected[$i]) {
        die('Тест функции validateUserForm НЕ пройден! Функция вернула: ' . $i . var_dump($result));
    }
}

echo 'Тест функции validateUserForm пройден.' . PHP_EOL;