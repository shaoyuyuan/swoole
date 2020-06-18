<?php
    $http = new Swoole\Http\Server("0.0.0.0", 9501);
    
    $http->on('request', function ($req, $resp) use ($http) {
        $resp->detach();
        $http->send($resp->fd, "HTTP/1.1 200 OK\r\nServer: server\r\n\r\nHello World\n");
    });
    
    $http->start();

