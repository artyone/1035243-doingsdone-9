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
            'value' => '?'
        ];
    }
    if ($projectId) {
        $criteria[] = [
            'field' => 'project_id',
            'sign' => ' = ',
            'value' => '?'
        ];
    }
    if ($showCompleted === 0) {
        $criteria[] = [
            'field' => 'status',
            'sign' => ' = ',
            'value' => '?'
        ];

    }
    switch ($timeRange) {
        case 'today' :
            $criteria[] = [
                'field' => 'expiration_time',
                'sign' => ' = ',
                'value' => '?'
            ];
            break;
        case 'tommorrow' :
            $criteria[] = [
                'field' => 'expiration_time',
                'sign' => ' = ',
                'value' => '?'
            ];
            break;
        case 'expired' :
            $criteria[] = [
                'field' => 'expiration_time',
                'sign' => '<',
                'value' => '?'
            ];
            break;
    }
    return $criteria;
}

function addCriteriaToQuery(string $sqlQuery, array $criteria)
{
    $result = $sqlQuery . " WHERE ";
    $count = count($criteria);
    foreach ($criteria as $value) {
        $result = $result . $value['field'] . $value['sign'] . $value['value'];
        $count --;
        if ($count) {
            $result .= " && ";
        }
    }
    return $result;
}

function buildArrayForPrepareStmt(int $userId, ?int $projectId, ?int $showCompleted, ?string $timeRange) : array
{
    $array = [];
    if ($userId) {
        $array[] = $userId;
    }
    if ($projectId) {
        $array[] = $projectId;
    }
    if ($showCompleted === 0) {
        $array[] = $showCompleted;
    }
    switch ($timeRange) {
        case 'today' :
            $array[] = date('Y-m-d');
            break;
        case 'tommorrow' :
            $array[] = date('Y-m-d', strtotime('+1 day'));
            break;
        case 'expired' :
            $array[] = date('Y-m-d', strtotime('-1 day'));
            break;
    }
    return $array;
}