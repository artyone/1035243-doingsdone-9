<?php

/**
 * Функция создания URL адреса для строки запроса
 * @param string|null $projectId ID проекта
 * @param string|null $showCompleted переменная состояния показа выполненных
 * @param string|null $timeRange временной интервал показа задач
 * @param int|null $taskId идентификатор задачи, которой потребуется изменить статус
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
    if (!isset($array[$key])) {
        return null;
    }
    if ($key = 'projectId') {
        return (int)$array[$key];
    }
    return htmlspecialchars(trim($array[$key]));
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

/**
 * Функция получения данных из $_GET для создания задачи
 * @param array $data массив данных для преобразования
 * @return array возвращает массив преоборазованных данных
 */
function getTaskData(array $data) : array
{
    $taskData['name'] = htmlspecialchars(trim($data['name'])) ?? null;
    $taskData['project_id'] = (int)($data['project_id']) ?? null;
    $taskData['expiration_date'] = htmlspecialchars(trim($data['expiration_date'])) ?? null;
    return $taskData;
}

/**
 * Функция получения данных из $_GET для создания пользователя
 * @param array $data массив данных для преобразования
 * @return array возвращает массив преоборазованных данных
 */
function getUserData(array $data) : array
{
    $userData['email'] = htmlspecialchars(trim($data['email'])) ?? null;
    $userData['password'] = htmlspecialchars(trim($data['password'])) ?? null;
    $userData['name'] = htmlspecialchars(trim($data['name'])) ?? null;
    return $userData;
}

/**
 * Функция получения данных из $_GET для создания проекта
 * @param array $data массив данных для преобразования
 * @return array возвращает массив преоборазованных данных
 */
function getProjectData(array $data) : array
{
    $projectData['name'] = htmlspecialchars(trim($data['name'])) ?? null;
    return $projectData;
}

/**
 * Функция получения данных из $_GET для аутентификации пользователя
 * @param array $data массив данных для преобразования
 * @return array возвращает массив преоборазованных данных
 */
function getAuthData(array $data) : array
{
    $projectData['email'] = htmlspecialchars(trim($data['email'])) ?? null;
    $projectData['password'] = htmlspecialchars(trim($data['password'])) ?? null;
    return $projectData;
}