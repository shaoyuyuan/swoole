<?php
    $serv = new Swoole\Server('127.0.0.1', 9501);
    
    $serv->set(['task_worker_num' => 4]);
    
    $serv->on('receive', function ($serv, $fd, $from_id, $data) {
        $task_id = $serv->task($data);
        echo "Dispatch AsysncTask: id=$task_id\n";
    });
    
    $serv->on('task', function ($serv, $task_id, $from_id, $data) {
        echo "New AsynTask[id=$task_id]".PHP_EOL;
        
        $serv->finish("$data -> OK");
    });
    
    $serv->on('finish', function ($serv, $task_id, $data) {
        echo "AsynTask[$task_id] Finish: $data".PHP_EOL;
    });
    
    $serv->start();
