<?php

date_default_timezone_set('Asia/shanghai');

$startTime = microtime(TRUE);

/* 写本地日志 */
$text = '本地日志 : ' . date('Y-m-d H:i:s') . PHP_EOL;
file_put_contents('access.log', $text, FILE_APPEND);

/* 写远程日志 */
$text = '[' . date('Y年m月d日 H时i分s秒'). ']日志数据';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://zyee.org/log-api.php');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['info' => $text]);
$result = curl_exec($ch);
curl_close($ch);

$endTime = microtime(TRUE);

echo '本次请求时间 ' . ($endTime - $startTime) * 1000 . 'ms ' . PHP_EOL;
