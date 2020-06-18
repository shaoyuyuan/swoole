<?php
    $ws = new Swoole\WebSocket\Server("0.0.0.0", 9502);
    
    $ws->set([
        'open_websocket_close_frame' => true,
    ]);
    
    /** @var TYPE_NAME $request */
    $ws->on('open', function ($ws, $request) {
//        var_dump($request->fd, $request->get, $request->server);
//        var_export($ws->connection_info($request->fd));
        $ws->push($request->fd, "hello, welcome\n");
    });
    
    $ws->on('message', function ($ws, $frame) {
        var_export($frame);
        if ($frame->opcode == 0x08) {
            echo "Close frame received: Code {$frame->code} Reason {$frame->reason}\n";
        } else {
            echo "Message received: {$frame->data}\n";
        }
//        echo "Message: {$frame->data}\n";
        if ($frame->data == 'close') {
            if($ws->disconnect($frame->fd, 1000, '客户端主动关闭')) {
                $ws->close($frame->fd);
                return false;
            }
        }
        $ws->push($frame->fd, "server: {$frame->data}");
    });
    
    $ws->on('close', function ($ws, $fd) {
        echo "client-{$fd} is closed\n";
    });
    
    
    $ws->start();
    
    