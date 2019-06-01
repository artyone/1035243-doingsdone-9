<?php

require_once 'bootstrap.php';
require_once('vendor/autoload.php');

$connection = connection($config['dbWork']);

$transport = new Swift_SmtpTransport('phpdemo.ru', 25);
$transport->setUsername('keks@phpdemo.ru');
$transport->setPassword('htmlacademy');

$mailer = new Swift_Mailer($transport);
$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

$users = getUsers($connection);

if ($users) {
    foreach ($users as $user) {
        $tasks = getTasks($connection, $user['id'], null, 0, 'today');
        $listTasks = [];
        $recipient[$user['email']] = $user['name'];
        if ($tasks) {
            foreach ($tasks as $task) {
                $listTasks[] = $task['name'];
            }
        }

        if ($listTasks) {
            $message = 'Уважаемый, ' . $user['name'] . '! <br>У вас на сегодня запланировано: <br>' . implode(', <br>', $listTasks);
            $letter = new Swift_Message();
            $letter->setSubject("Уведомление от сервиса «Дела в порядке»");
            $letter->setFrom(['keks@phpdemo.ru' => 'Дела в порядке']);
            $letter->setTo($recipient);
            $letter->setBody($message, 'text/html');
            $result = $mailer->send($letter);
        }

        if ($result) {
            print('Письма успешно отправлены');
        } else {
            print('Письма не отправлены' . $result);
        }
    }
}