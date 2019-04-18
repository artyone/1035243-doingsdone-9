<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'functions/templates.php';

$show_complete_tasks = rand(0, 1);
$categories = ['Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];
$tasks = [
    [
        'name' => 'Собеседование в IT компании',
        'date' => '18.04.2019',
        'category' => 'Работа',
        'status' => false
    ],

    [
        'name' => 'Выполнить тестовое задание',
        'date' => '20.04.2019',
        'category' => 'Работа',
        'status' => false
    ],
    [
        'name' => 'Сделать задание первого раздела',
        'date' => '18.04.2019',
        'category' => 'Учеба',
        'status' => true
    ],
    [
        'name' => 'Встреча с другом',
        'date' => '19.04.2019',
        'category' => 'Входящие',
        'status' => false
    ],
    [
        'name' => 'Купить корм для кота',
        'date' => null,
        'category' => 'Домашние дела',
        'status' => false
    ],
    [
        'name' => 'Заказать пиццу',
        'date' => null,
        'category' => 'Домашние дела',
        'status' => false
    ]
];

$page_content = includeTemplate('index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = includeTemplate('layout.php',
    [
        'page_content' => $page_content,
        'categories' => $categories,
        'title' => 'Дела в порядке - Главная',
        'user_name' => 'Артем Тихонов',
        'tasks' => $tasks
    ]
);

print($layout_content);
