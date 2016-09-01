<?php

$worker = new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);
$worker->addServer('127.0.0.1', 4731);
$worker->addServer('127.0.0.1', 4732);

/* 本地日志处理 */
$worker->addFunction('accessLog', function (GearmanJob $job) {
    $text = $job->workload();
    if (file_put_contents('access.log', $text, FILE_APPEND) !== FALSE)
    {
        echo  $job->handle() . '写本地日志成功 : ' . $text . PHP_EOL;
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
    $result = curl_exec($ch);
    curl_close($ch);
    echo $job->handle() . '写远程日志成功' . PHP_EOL;
});

/* 启动worker */
while($worker->work());