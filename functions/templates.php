<?php

function includeTemplate($name, array $data = []) {
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

/**
 * Проверяет важна ли задача (до окончания меньше суток)
 * @param string $date дата выполнения задачи
 * @param bool $status факт выполнение задачи
 * @return bool
 */

function isImportant($date, $status)
{
    if ($status) {
        return false;
    }
    if (!$date) {
        return false;
    }
    if (strtotime($date) - time() >= 86400) {
        return false;
    }
    return true;
}

