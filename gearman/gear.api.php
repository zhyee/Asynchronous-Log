<?php
date_default_timezone_set('Asia/shanghai');

$startTime = microtime(TRUE);

$client = new GearmanClient();
$client->addServer('127.0.0.1', 4730);

/* 本地写访问日志 */
$text = 'access log : ' . date('Y-m-d H:i:s') . PHP_EOL;
$jobHandle = $client->doBackground('accessLog', $text);

/* 本地写错误日志 */
$text = 'error log : ' . date('Y-m-d H:i:s') . PHP_EOL;
$jobHandle2 = $client->doBackground('errorLog', $text);

/* curl调用远程计数接口 */
$jobHandle3 = $client->doBackground('curlCount', 0);

/* curl写远程日志 */
$text = '写入日志数据 (' . date('Y-m-d H:i:s') . ')';
$jobHandle4 = $client->doBackground('curlLog', $text);

$endTime = microtime(TRUE);

echo '成功... 本次花费时间 ' . ($endTime - $startTime) * 1000 . 'ms ' . PHP_EOL;