<?php

/* client socket */

$client = stream_socket_client('tcp://192.168.56.102:10000', $errno, $errstr, 30);

if (!$client)
{
    throw new Exception($errstr . ' : ' . $errno);
}

$content = '日志数据：' . date('Y-m-d H:i:s') . PHP_EOL;

fwrite($client, $content, filesize($content));

$content = '';
while (!feof($client))
{
    $content .= fread($client, 1024);
}

fclose($client);

echo $content . PHP_EOL;
