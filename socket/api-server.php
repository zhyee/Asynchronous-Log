<?php

$info = strval($_POST['info']);

if (file_put_contents('log.txt', $info, FILE_APPEND) !== FALSE)
{
    echo 'success';
}
else
{
    echo 'fail';
}