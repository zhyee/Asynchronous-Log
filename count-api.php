<?php

$logFile = 'count.log';

if (!file_exists($logFile))
{
    file_put_contents('count.log', '1');
    echo '1';
    exit(0);
}

$prevCount = (int)file_get_contents($logFile);
file_put_contents($logFile, ++$prevCount);

echo $prevCount;