<?php
use Workerman\Worker; //подключаем библиотеку

require_once __DIR__ . '/../vendor/autoload.php';

$wsWorker = new Worker('websocket://0.0.0.0:2346'); //инициализируем
$wsWorker->count = 4; //колво процессов которые будет обрабатывать подключение от клиентов

//callback на подключение пользователя
$wsWorker->onConnect = function ($connection) {
    echo "New connection\n";
};

//обработка сообщений
// $connection  соединение, $data -  данные
$wsWorker->onMessage = function ($connection, $data) use ($wsWorker) {
    $obj = json_decode($data);
    $inf = $obj->{'inf'};

    if(endswith("$inf", 'Won!') || endswith("$inf", 'Draw!')){
        date_default_timezone_set('Europe/Minsk');
        $date_now =  date('l jS \of F Y h:i:s A');

        //сохранение в файл
        $fd = fopen("gaga.txt", 'a') or die("не удалось создать файл");
        fwrite($fd, $date_now."\n");
        for($i=0; $i<9; $i++){
            $c[$i]=$obj->{'c'}[$i];
            fwrite($fd, $c[$i]);
            if($i==2||$i==5){
                fwrite($fd, "\n");
            }
        }
        fwrite($fd, "\n"."$inf"."\n\n");
        fclose($fd);
    }

    //отправка сообщения
    foreach($wsWorker->connections as $clientConnection) {
        $clientConnection->send($data);
    }
};

//callback на отключение пользователя
$wsWorker->onClose = function ($connection) {
    echo "\nConnection closed\n";
};

Worker::runAll();

function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}