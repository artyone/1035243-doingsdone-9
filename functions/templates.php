<?php


/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент. Функция предоставлена академией
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

function exitSession ()
{
    $_SESSION = [];
    header('Location: ' . 'index.php');
    die();
}