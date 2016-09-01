<?php
date_default_timezone_set('Asia/shanghai');
$startTime = microtime(TRUE);

$client = new GearmanClient();

//server1
if (!$client->addServer('127.0.0.1', 4730))
{
    //记录错误日志 127.0.0.1:4730 has down
}

//server2
if (!$client->addServer('127.0.0.1', 4731))
{
    //记录错误日志 127.0.0.1:4731 has down
}

//server3
if (!$client->addServer('127.0.0.1', 4732))
{
    //记录错误日志 127.0.0.1:4732 has down
}

/* 本地访问日志 */
$text = '本地日志 : ' . date('Y年m月d日 H时i分s秒') . PHP_EOL;
$jobHandle = $client->doBackground('accessLog', $text);

/* 写远程日志 */
$text = '[' . date('Y年m月d日 H时i分s秒'). ']日志数据';
$jobHandle2 = $client->doBackground('curlLog', $text);

$endTime = microtime(TRUE);

echo '本次处理时间 ' . ($endTime - $startTime) * 1000 . 'ms ' . PHP_EOL;