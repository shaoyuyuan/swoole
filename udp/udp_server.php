<?php

$serv = new Swoole\Server("127.0.0.1", 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

$serv->on(/**
 * @param $serv
 * @param $data
 * @param $clientInfo
 */ 'Packet', function ($serv, $data, $clientInfo)
{
	$serv->sendto($clientInfo['address'], $clientInfo['port'], "Server" . $data);
	var_dump($clientInfo);
});

$serv->start();
