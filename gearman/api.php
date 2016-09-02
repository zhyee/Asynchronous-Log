<?php
date_default_timezone_set('Asia/shanghai');
$startTime = microtime(TRUE);
$client = new GearmanClient();
//server1
if (!$client->addServer('192.168.56.101', 4730))
{
    echo 'the server 192.168.56.101:4730 cannot be used' . PHP_EOL;
}
//server2
if (!$client->addServer('192.168.56.102', 4730))
{
    echo 'the server 192.168.56.102:4730 cannot be used' . PHP_EOL;
}

/* 写本地日志 */
$text = $_SERVER['HTTP_HOST'] . ' 本地日志 : ' . date('Y-m-d H:i:s') . PHP_EOL;
$jobHandle = $client->doBackground('localLog', $text);

/* 写远程日志 */
$text = $_SERVER['HTTP_HOST'] . ' 远程日志 : ' . date('Y-m-d H:i:s') . PHP_EOL;
$jobHandle2 = $client->doBackground('curlLog', $text);

$endTime = microtime(TRUE);

echo '本次处理时间 ' . ($endTime - $startTime) * 1000 . 'ms ' . PHP_EOL;