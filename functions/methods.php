<?php

/**
 * Функция создания URL адреса для строки запроса
 * @param string|null $projectId ID проекта
 * @param string|null $showCompleted переменная состояния показа выполненных
 * @param string|null $timeRange временной интервал показа задач
 * @return string возвращает строку для добавление в глобальный URL адрес страницы
 */
function buildProjectUrl(?string $projectId, ?string $showCompleted, ?string $timeRange) : string
{
    $urlData = [];

    if ($projectId) {
        $urlData['projectId'] = $projectId;
    }

    if ($showCompleted) {
        $urlData['showCompleted'] = $showCompleted;
    }

    if ($timeRange) {
        $urlData['timeRange'] = $timeRange;
    }

    return '/?' . http_build_query($urlData);
}

/**
 * Функция получения параметров из $_GET или $_POST
 * @param array $array массив $_GET или $_POST
 * @param string $key ключ для поиска в массиве
 * @param null $default значение по умолчанию, если не найден ключ
 * @return string|null возвращает значение ключа из массива
 */
function getParam (array $array, string $key, $default = null) : ?string
{
    return $array[$key] ?? $default;
}

function uploadFile($file, $dir)
{
    $fileName = $file['name'];
    $count = 0;
    while (file_exists($dir . '/uploads/' . $fileName)) {
        $fileName = pathinfo($file['name'], PATHINFO_FILENAME) . $count . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $count++;
    }

    $filePath = $dir . '/uploads/';
    $fileUrl = '/uploads/' . $fileName;
    if(!move_uploaded_file($file['tmp_name'], $filePath . $fileName)) {
        $fileUrl = "";
    }
    return $fileUrl;
}