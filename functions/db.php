<?php

//вопрос? а надо ли нам каждый раз передавать результат dbConnect() в каждую функцию или можно её задать в коде
//каждой функции?
function dbConnect()
{
    $connect = mysqli_connect('localhost', 'root', '123', 'doingdone');
    if (!$connect) {
        return print('no connection');
    }
    mysqli_set_charset($connect, "utf8");

    return $connect;
}

function getCategories($dbConnect, $user_id)
{
    $sqlQuery = 'SELECT id, name FROM project WHERE user_id = ' . $user_id;
    $resource = mysqli_query($dbConnect, $sqlQuery);
    $result = mysqli_fetch_all($resource, MYSQLI_ASSOC);
    return $result;
}


function getTasks($dbConnect, $user_id)
{
    $sqlQuery = "SELECT id, status, name, file_link, DATE_FORMAT(expiration_time, '%d.%m.%Y') as expiration_time, 
       project_id FROM task WHERE user_id = " . $user_id;
    $resource = mysqli_query($dbConnect, $sqlQuery);
    $result = mysqli_fetch_all($resource, MYSQLI_ASSOC);
    return $result;
}

function getUser($dbConnect, $user_id)
{
    $sqlQuery = "SELECT id, name FROM user WHERE id = " . $user_id;
    $resource = mysqli_query($dbConnect, $sqlQuery);
    $result = mysqli_fetch_assoc($resource);
    return $result;
}

/* Подумать о смысле жизни и что лучше обратиться к базе за подсчетом или обработать массив

function countProject($dbConnect, $id)
{
    $sqlQuery = "SELECT count(*) as count FROM task WHERE project_id = " . $id  . ' && user_id = 2';
    $resource = mysqli_query($dbConnect, $sqlQuery);
    $result = mysqli_fetch_assoc($resource);
    return $result;
}*/