<?php


/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function includeTemplate(string $name, array $data = []) : string
{
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
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
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
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}



function formDataFilter($data)
{
    $resultData = [];
    foreach ($data as $key => $value) {
        $resultData[$key] = trim($value);
        $resultData[$key] = htmlspecialchars($resultData[$key]);
    }
    return $resultData;
}

function validateTaskForm($data, $connection, $user)
{
    $error = [];
    if (empty($data['name'])) {
        $error['name'] = 'Заполните название задачи';
    }
    if (!('id' === array_search($data['project'], getProject($connection, $user['id'], $data['project'])))) {
        $error['project'] = 'Выберите существующий проект';
    }
    if (!is_date_valid($data['date']) && !empty($data['date'])) {
        $error['date'] = 'Введите корректный формат даты';
    }
    if (((strtotime($data['date']) - time() <= -86400)) && !empty($data['date'])){
        $error['date'] = 'Дата должна быть не раньше текущей';
    }
    return $error;
}