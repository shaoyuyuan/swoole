<?php

$serv = new Swoole\Server('127.0.0.1', 9501);


$serv->on('Connect', function ($serv, $fd) {
	echo "Client: Connect. \n";
});

$serv->on('Receive', function ($serv, $fd, $from_id, $data) {
	$serv->send($fd, 'Server:' . $data);
});

$serv->on('start', function ($serv) {
    echo $serv->master_pid;
});

$serv->on('Close', function ($serv, $fd) {
	echo "Client: Close.\n";
});

$serv->start();
