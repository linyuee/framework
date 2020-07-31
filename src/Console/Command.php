<?php
/**
 * Created by PhpStorm.
 * User: hw201902
 * Date: 2020/7/30
 * Time: 11:46
 */

namespace Lyue\Console;


use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends \Symfony\Component\Console\Command\Command
{
    protected $signature;
    protected $desc;
    protected $help = '';
    protected $option;
    private $exitCode = 0;
    private $output;
    private $input;

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $command = $this->signature;
        preg_match_all("/(?<={)[^}]+/", $command, $arrMatches);
        $this
            // 命令的名称 （"php console_command" 后面的部分）
            ->setName(explode('{', $command)[0])
            // 运行 "php console_command list" 时的简短描述
            ->setDescription($this->desc)
            // 运行命令时使用 "--help" 选项时的完整命令描述
            ->setHelp($this->help);
        // 配置一个参数
        //->addArgument('name', InputArgument::REQUIRED, 'what\'s model you want to create ?');
        foreach ($arrMatches[0] as $arrMatch) {
            $this->addArgument($arrMatch, InputArgument::REQUIRED, 'what\'s model you want to create ?');
        }

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;
        call_user_func([$this, 'handle']);
        $output->writeln('<bg=green;options=bold>[OK]</>');
        return $this->exitCode;
    }

    public function info($info)
    {
        $this->output->writeln("<fg=green>$info</>");
    }

    public function warning($info)
    {
        $this->output->writeln("<fg=red>$info</>");
    }

    public function getArgument($arg)
    {
        return $this->input->getArgument($arg);
    }


}
