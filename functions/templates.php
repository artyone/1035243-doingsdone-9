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
                'value' => $timeRange
            ];
            break;
        case RANGE_TOMORROW :
            $criteria[] = [
                'field' => 'expiration_time',
                'sign' => ' = ',
                'value' => $timeRange
            ];
            break;
        case RANGE_EXPIRED :
            $criteria[] = [
                'field' => 'expiration_time',
                'sign' => ' < ',
                'value' => $timeRange
            ];
            break;
    }
    return $criteria;
}

function addCriteriaToQuery(string $sqlQuery, array $criteria)
{
    $result = [];
    foreach ($criteria as $expression) {
        $result[] = $expression['field'] . $expression['sign'] . '?' ;
    }
    return $sqlQuery . ' WHERE ' . implode(' && ', $result);
}

function buildArrayForPrepareStmt(array $criteria) : array
{
    $prepareData = [];
    foreach ($criteria as $expression) {
        $prepareData[] = $expression['value'];
    }
    return $prepareData;

}