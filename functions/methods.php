<?php

/**
 * Функция создания URL адреса для строки запроса
 * @param string|null $projectId ID проекта
 * @param string|null $showCompleted переменная состояния показа выполненных
 * @param string|null $timeRange временной интервал показа задач
 * @return string возвращает строку для добавление в глобальный URL адрес страницы
 */
function buildProjectUrl(?string $projectId, ?string $showCompleted, ?string $timeRange, ?int $taskId = null) : string
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
    if ($taskId) {
        $urlData['taskId'] = $taskId;
    }

    return '/?' . http_build_query($urlData);
}

/**
 * Функция получения параметров из $_GET или $_POST
 * @param array $array массив $_GET или $_POST
 * @param string $key ключ для поиска в массиве
 * @return string|null возвращает значение ключа из массива
 */
function getParam (array $array, string $key) : ?string
{
    if (isset($array[$key])) {
        return trim(htmlspecialchars($array[$key]));
    } else {
        return null;
    }
}

/**
 * Функция записи файла на сервер и получение ссылки на него с переименованием и проверкой корректности загрузки
 * @param array $file массив полученный из $_FILE с данными по загруженному пользователем файлу
 * @param string $dir директория для загрузки файла на сервере
 * @return string возвращает ссылку на файл
 */
function uploadFile(array $file, string $dir) : ?string
{

    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('Ошибка при загрузке файла. Код ошибки: ' . $file['error']);
    }

    $fileName = validateFileName($file['name'], $dir);

    $fileLink = '/uploads/' . $fileName;

    if(!move_uploaded_file($file['tmp_name'], $dir . $fileName)) {
        die('Ошибка записи файла в папку проекта');
    }

    return $fileLink;
}