<?php

$info = strval($_POST['info']) . ' ' . date('Y-m-d H:i:s') . PHP_EOL;

if (file_put_contents('info.log', $info, FILE_APPEND) !== FALSE)
{
    echo 'success';
}
else
{
    echo 'fail';
}