<?php
/**
 * Created by PhpStorm.
 * User: zyee
 * Date: 2016/8/31
 * Time: 16:17
 */


// 实现守护进程
class Deamonlize
{
    public static function Deamonlize()
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