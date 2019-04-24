<?php
/*
function dbConnect()
{
    $connect = mysqli_connect('localhost', 'root', '123', 'doingdone');
    if (!$connect) {
        return print('no connection');
    }
    mysqli_set_charset($connect, "utf8");

    return $connect;
}

function countProject($dbConnect, $id)
{
    $sqlQuery = 'SELECT project_id, count(*) as count FROM task WHERE project_id = ' . $id . ' && user_id = 2';
    $resource = mysqli_query($dbConnect, $sqlQuery);
    $result = mysqli_fetch_assoc($resource);
    return $result;
}

print_r(countProject(dbConnect(), 1));*/