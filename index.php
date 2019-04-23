<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'functions/templates.php';
require_once 'functions/db.php';

$showCompleteTasks = rand(0, 1);
$categories = getCategories(dbConnect(), 1);
$tasks = getTasks(dbConnect(), 1);
    /*
    [
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
];*/

$pageContent = includeTemplate('main.php', ['tasks' => $tasks, 'showCompleteTasks' => $showCompleteTasks]);
$layoutContent = includeTemplate('layout.php',
    [
        'pageContent' => $pageContent,
        'categories' => $categories,
        'title' => 'Дела в порядке - Главная',
        'userName' => 'Артем Тихонов',
        'tasks' => $tasks
    ]
);

print($layoutContent);
