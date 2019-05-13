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

/**
 * Функция создания массива "критерий" с данными по полю, по которому будет отбор, знаку отбора и значению
 * @param int $userId идентификатор пользователя
 * @param int|null $projectId идентификатор проекта
 * @param int|null $showCompleted статус проекта
 * @param string|null $timeRange условное обозначение временного интервала
 * @return array возвращает ассоциативный массив с данными по критериям
 */
function buildCriteria(int $userId, ?int $projectId, ?int $showCompleted, ?string $timeRange) : array
{
    $criteria = [];
    if ($userId) {
        $criteria[] = [
            'field' => 'user_id',
            'sign' => ' = ',
            'value' => $userId
        ];
    }
    if ($projectId) {
        $criteria[] = [
            'field' => 'project_id',
            'sign' => ' = ',
            'value' => $projectId
        ];
    }
    if ($showCompleted === 0) {
        $criteria[] = [
            'field' => 'status',
            'sign' => ' = ',
            'value' => $showCompleted
        ];
    }
    switch ($timeRange) {
        case RANGE_TODAY :
            $criteria[] = [
                'field' => 'expiration_time',
                'sign' => ' = ',
                'value' => date('Y-m-d')
            ];
            break;
        case RANGE_TOMORROW :
            $criteria[] = [
                'field' => 'expiration_time',
                'sign' => ' = ',
                'value' => date('Y-m-d', strtotime('+1 day'))
            ];
            break;
        case RANGE_EXPIRED :
            $criteria[] = [
                'field' => 'expiration_time',
                'sign' => ' < ',
                'value' => date('Y-m-d')
            ];
            break;
    }
    return $criteria;
}

/**
 * Функция создания строки для создания запроса в базу данных
 * @param string $sqlQuery основной текст запроса
 * @param array $criteria добавочные критерии для создания отбора в запросе
 * @return string возвращает строку с текстом запроса в базу данных
 */
function addCriteriaToQuery(string $sqlQuery, array $criteria) : string
{
    $result = [];
    foreach ($criteria as $expression) {
        $result[] = $expression['field'] . $expression['sign'] . '?' ;
    }
    return $sqlQuery . ' WHERE ' . implode(' && ', $result);
}

/**
 * Функия создания массива для подготовленного выражения запроса в базу данных
 * @param array $criteria массив критерий со значениями
 * @return array возвращает готовый массив для передачи его в подготовленное выражение
 */
function buildArrayForPrepareStmt(array $criteria) : array
{
    $prepareData = [];
    foreach ($criteria as $expression) {
        $prepareData[] = $expression['value'];
    }
    return $prepareData;
}