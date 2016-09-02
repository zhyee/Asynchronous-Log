<?php

$worker = new GearmanWorker();
$worker->addServer('192.168.56.101', 4730);  //server1
$worker->addServer('192.168.56.102', 4730);  //server2

/* 本地日志 */
$worker->addFunction('localLog', function (GearmanJob $job) {
    $text = $job->workload();
    if (file_put_contents('local.log', $text, FILE_APPEND) !== FALSE)
    {
        echo $job->handle() . '写本地日志成功' . PHP_EOL;
    }
});


/* 远程日志处理 */
$worker->addFunction('curlLog', function (GearmanJob $job) {
    $text = $job->workload();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://zyee.org/log-api.php');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['info' => $text]);
    $result = strval(curl_exec($ch));
    curl_close($ch);
    if($result === 'success')
    {
        echo $job->handle() . '写远程日志成功' . PHP_EOL;
    }
});

/* 启动worker */
while($worker->work());