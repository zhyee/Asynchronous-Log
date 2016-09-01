<?php

date_default_timezone_set('Asia/shanghai');

$startTime = microtime(TRUE);

/* 本地写访问日志 */
$text = 'access log : ' . date('Y-m-d H:i:s') . PHP_EOL;
file_put_contents('access.log', $text, FILE_APPEND);

/* 本地写错误日志 */
$text = 'error log : ' . date('Y-m-d H:i:s') . PHP_EOL;
file_put_contents('error.log', $text, FILE_APPEND);

/* curl调用远程计数接口 */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://zyee.org/count-api.php');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = (int)curl_exec($ch);
curl_close($ch);

/* curl写远程日志 */
$text = '写入日志数据 (' . date('Y-m-d H:i:s') . ')';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://zyee.org/log-api.php');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['info' => $text]);
$result = curl_exec($ch);
curl_close($ch);

$endTime = microtime(TRUE);

echo '成功... 本次花费时间 ' . ($endTime - $startTime) * 1000 . 'ms ' . PHP_EOL;
