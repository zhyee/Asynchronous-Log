<?php

$info = strval($_POST['info']);

if (file_put_contents('log-api.log', $info, FILE_APPEND) !== FALSE)
{
    echo 'success';
}
else
{
    echo 'fail';
}