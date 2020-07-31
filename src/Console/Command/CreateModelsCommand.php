<?php
/**
 * Created by PhpStorm.
 * User: hw201902
 * Date: 2020/7/30
 * Time: 11:24
 */

namespace Lyue\Console\Command;


use function Composer\Autoload\includeFile;
use Lyue\Console\Command;


class CreateModelsCommand extends Command
{

    protected $signature = 'make:command {name}';
    protected $desc = 'make a command';

    public function handle()
    {
        $template = file_get_contents(__DIR__ . '/../stub/command.stub');
        $source = str_replace('{{class_name}}', $this->getArgument('name'), $template);
        $file_path = BASE_PATH . '/app/Console/Command';
        //写入文件
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
        }
        $file = $file_path . '/' . $this->getArgument('name') . '.php';

        if (!file_exists($file) && file_put_contents($file, $source)) {
            $this->info('创建成功');
        } else {
            $this->warning('创建失败');
        }
    }

}
