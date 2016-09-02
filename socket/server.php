<?php

/* socket server */

$server = stream_socket_server('tcp://0.0.0.0:10000', $errno, $errstr);

if (!$server)
{
    throw new Exception($errstr . ' : ' . $errno);
}

while ($conn = stream_socket_accept($server))
{
    $content = '';
    while (!feof($conn))
    {
        $content .= fread($conn, 1024);
    }

    if (file_put_contents('log.txt', $content, FILE_APPEND) !== FALSE)
    {
        fwrite($conn, 'success', filesize('success'));
    }
    else
    {
        fwrite($conn, 'fail', filesize('fail'));
    }

    fclose($conn);
}

fclose($server);
