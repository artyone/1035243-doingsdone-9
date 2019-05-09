<?php

$data = [
    [
        'email' => '',
        'password' => '12345qW'
    ],
    [
        'email' => '123@mail.ru',
        'password' => ''
    ],
    [
        'email' => '',
        'password' => ''
    ],
    [
        'email' => 'sdfsf',
        'password' => ''
    ],
    [
        'email' => 'sdfsf@mail.ru',
        'password' => '1234Q'
    ],
    [
        'email' => 'afsdfsfsadfsfsafasfsfsasdfsdfasfsafasfsafsfsfsafsafsfsafasfsfsafasfsafasfsafsfsafasfasfsafasfasfasfasfasfasfasfasfsafasfsafasdfddfdfdfdsfafasfsdffdfdfdffasfsfsfasafasfsafasfasfasfsfsfsfasfasfasfasfsafsafsafasfsafsafsfsafsafasfasfasfsafsafsafasfasfsafasfasfsfasfasfsdfsadf',
        'password' => 'afsdfsfsadfsfsafasfsfsasdfsdfasfsafasfsafsfsfsafsafsfsafasfsfsafasfsafasfsafsfsafasfasfsafasfasfasfasfasfasfasfasfsafasfsafasdfdfdadfsfasfsafasfsafasfsffdfdffasfsfsfasafasfsafasfasfasfsfsfsfasfasfasfasfsafsafsafasfsafsafsfsafsafasfasfasfsafsafsafasfasfsafasfasfsfasfasfsdfsadf'
    ]
];

$expected = [
    [
        'email' => 'Заполните e-mail адрес'
    ],
    [
        'password' => 'Заполните пароль'
    ],
    [
        'email' => 'Заполните e-mail адрес',
        'password' => 'Заполните пароль'
    ],
    [
        'email' => 'Указан некорректный e-mail адрес',
        'password' => 'Заполните пароль'
    ],
    [

    ],
    [
        'email' => 'E-mail адрес не должен превышать 255 символов',
        'password' => 'Пароль не должен превышать 255 символов'
    ]
];

for ($i = 0; $i < count($data); $i ++) {
    $result = validateAuthForm($data[$i]);
    if ($result !== $expected[$i]) {
        die('Тест функции validateAuthForm НЕ пройден! Функция вернула: ' . $i . var_dump($result));
    }
}

echo 'Тест функции validateAuthForm пройден.'.PHP_EOL;