<?php

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

function verifyTime($time, $status) {
    $time_status = false;
    if ((strtotime($time) - strtotime(date('D, d M Y H:i:s')) < 86400) && !$status && ($time != 'Нет')) {
        $time_status = true;
    }
    return $time_status;
}

?>