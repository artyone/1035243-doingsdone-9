<?php

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

function countProject($dbConnect, $id)
{
    $sqlQuery = "SELECT count(*) as count FROM task WHERE project_id = " . $id;
    $resource = mysqli_query($dbConnect, $sqlQuery);
    $result = mysqli_fetch_assoc($resource);
    return $result;
}