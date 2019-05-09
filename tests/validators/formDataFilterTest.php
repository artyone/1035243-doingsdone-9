<?php

$data = [
    [
        'name' => ' dfdf ',
        'date' => ' 10.03.1990 ',
        'email' => ' 123@mail.ru '
    ],
    [
        'name' => '<a href=\"test\">Test</a>',
    ]

];

$expected = [
    [
        'name' => 'dfdf',
        'date' => '10.03.1990',
        'email' => '123@mail.ru'
    ],
    [
        'name' => '&lt;a href=\&quot;test\&quot;&gt;Test&lt;/a&gt;',
    ]
];

for ($i = 0; $i < count($data); $i ++) {
    $result = formDataFilter($data[$i]);
    if ($result !== $expected[$i]) {
        die('Тест функции formDataFilter НЕ пройден! Функция вернула: ' . var_dump($result));
    }
}

echo 'Тест функции formDataFilter пройден.'.PHP_EOL;