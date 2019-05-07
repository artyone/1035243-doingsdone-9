<?php

/**
 * Проверяет важна ли задача (до окончания меньше суток)
 * @param string $date дата выполнения задачи
 * @param bool $status факт выполнение задачи
 * @return bool
 */

function isImportant(?string $date, bool $status) : bool
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

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'. Функция предоставлена академией
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Функция преобразования символов и удаления пробелов
 * @param array $data массив данных (из $_POST) требующий преобразований
 * @return array массив без пробелов в начале и конце строк с преобразованными символами
 */
function formDataFilter(array $data) : array
{
    $resultData = [];
    foreach ($data as $key => $value) {
        $resultData[$key] = trim($value);
        $resultData[$key] = htmlspecialchars($resultData[$key]);
    }
    return $resultData;
}



