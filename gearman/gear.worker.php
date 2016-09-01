<?php

$worker = new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);

/* 添加本地日志处理 */
$worker->addFunction('accessLog', function (GearmanJob $job) {
    $text = $job->workload();
    if (file_put_contents('access.log', $text, FILE_APPEND) !== FALSE)
    {
        echo  $job->handle() . '写本地日志成功 : ' . $text . PHP_EOL;
    }
});

/* 本地错误日志 */
$worker->addFunction('errorLog', function (GearmanJob $job) {
    $text = $job->workload();
    if (file_put_contents('error.log', $text, FILE_APPEND) !== FALSE)
    {
        echo $job->handle() . '写错误日志成功 : ' . $text . PHP_EOL;
    }
});

/* 远程计数 */
$worker->addFunction('curlCount', function (GearmanJob $job) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://zyee.org/count-api.php');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = (int)curl_exec($ch);
    curl_close($ch);

    echo $job->handle() . '远程计数成功' . PHP_EOL;

});

/* 远程日志 */
$worker->addFunction('curlLog', function (GearmanJob $job) {
    $text = $job->workload();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://zyee.org/log-api.php');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['info' => $text]);
    $result = curl_exec($ch);
    curl_close($ch);

    echo $job->handle() . '远程日志成功' . PHP_EOL;

});

/* 启动worker */
while($worker->work());