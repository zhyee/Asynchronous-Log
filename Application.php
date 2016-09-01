<?php

/* 网站基础功能 */

class Application
{

    /**
     * 守护进程化
     * @throws Exception
     */
    public static function deamonlize()
    {

        $pid = pcntl_fork();

        if ($pid == -1)
        {
            throw new Exception('fork子进程失败');
        }
        elseif ($pid > 0)
        {
            exit(0);
        }

        if (posix_setsid() == -1)
        {
            throw new Exception('make current process as a session leader fail');
        }

        if (strpos(__DIR__, ':\\') === FALSE && !chdir('/'))
        {
            throw new Exception('切换工作目录失败');
        }

        $pid = pcntl_fork();

        if ($pid == -1)
        {
            throw new Exception('fork子进程失败');
        }
        elseif  ($pid > 0)
        {
            exit(0);
        }
    }
}