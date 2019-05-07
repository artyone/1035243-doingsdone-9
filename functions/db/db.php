<?php

/**
 * Функция подключения к базе данных
 * @param array $config массив с данными подключениями
 * @return false|mysqli результат выполненения функции mysqli_connect
 */
function connection(array $config) : mysqli
{
    $connect = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
    if (!$connect) {
        print 'Ошибка при подключении к БД: ' . mysqli_connect_error();
        die();
    }
    mysqli_set_charset($connect, "utf8");
    return $connect;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных из академии
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}