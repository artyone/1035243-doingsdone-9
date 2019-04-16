<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$show_complete_tasks = rand(0, 1);
$categories = ['Входящие','Учеба','Работа','Домашние дела','Авто'];
$tasks = [
	[
	        'name'=>'Собеседование в IT компании',
    	    'date' => '01.12.2018',
            'category' => 'Работа',
            'status' => false
    ],

    [
            'name'=>'Выполнить тестовое задание',
    		'date' => '25.12.2018',
            'category' => 'Работа',
            'status' => false
    ],
    [
            'name'=>'Сделать задание первого раздела',
            'date' => '21.12.2018',
            'category' => 'Учеба',
            'status' => true
    ],
    [
            'name'=>'Встреча с другом',
            'date' => '22.12.2018',
            'category' => 'Входящие',
            'status' => false
    ],
    [
            'name'=>'Купить корм для кота',
            'date' => 'Нет',
            'category' => 'Домашние дела',
            'status' => false
    ],
    [
            'name'=>'Заказать пиццу',
            'date' => 'Нет',
            'category' => 'Домашние дела',
            'status' => false
    ]
];

function countCategories($tasks, $name) {
    $counter = 0;
    foreach ($tasks as $task) {
        if ($task['category'] == $name) {
            $counter ++;
        }
    }
    return $counter;
};

function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

$page_content = include_template('index.php', ['tasks' => $tasks,'show_complete_tasks'=> $show_complete_tasks]);
$layout_content = include_template('layout.php',
    [
            'page_content' => $page_content,
            'categories' => $categories,
            'title' => 'Дела в порядке - Главная',
            'user_name' => 'Артем Тихонов',
            'tasks' => $tasks
    ]
);

print($layout_content);

?>


