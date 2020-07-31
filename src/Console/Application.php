<?php
/**
 * Created by PhpStorm.
 * User: hw201902
 * Date: 2020/7/30
 * Time: 14:26
 */

namespace Lyue\Console;


class Application
{
    private $application;

    public function __construct(\Symfony\Component\Console\Application $application)
    {

        $this->application = $application;
    }

    public function init()
    {
        $this->registerCommands(BASE_PATH . '/app/Console/Command');
        $this->registerDefaultCommands(__DIR__ . '/Command');
    }

    private function registerCommands($path)
    {
        $filename = scandir($path);
        foreach ($filename as $k => $v) {
            // 跳过两个特殊目录   continue跳出循环
            if ($v == "." || $v == "..") {
                continue;
            }
            //截取文件名，我只需要文件名不需要后缀;然后存入数组。如果你是需要后缀直接$v即可
            $className = '\App\Console\Command\\' . substr($v, 0, strpos($v, "."));
            $this->application->add(new $className());
        }
    }
    private function registerDefaultCommands($path)
    {
        $filename = scandir($path);
        foreach ($filename as $k => $v) {
            // 跳过两个特殊目录   continue跳出循环
            if ($v == "." || $v == "..") {
                continue;
            }
            //截取文件名，我只需要文件名不需要后缀;然后存入数组。如果你是需要后缀直接$v即可
            $className = '\Lyue\Console\Command\\' . substr($v, 0, strpos($v, "."));
            $this->application->add(new $className());
        }
    }
}
