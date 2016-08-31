<?php
/**
 * Created by PhpStorm.
 * User: zyee
 * Date: 2016/8/31
 * Time: 16:58
 */

require 'deamonlize.php';

class Demo extends Deamonlize
{

    public function run()
    {
        while (TRUE)
        {
            file_put_contents('access.log', time() . PHP_EOL, FILE_APPEND);
            sleep(2);
        }
    }

}

Demo::Deamonlize();
(new Demo())->run();
