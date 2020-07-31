<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/9/10
 * Time: 下午3:01
 */

namespace Lyue\Exception;
class Handler
{
    public function handle()
    {
        error_reporting(0);
        set_error_handler(array($this, "errorHandler"), E_ALL | E_STRICT);
        set_exception_handler(array($this,'exceptionHandler'));
        register_shutdown_function(array($this, "shutdownErrorHandler"));
    }

    public function errorHandler($error_no, $error_msg, $error_file, $error_line)
    {
        var_dump($error_no);
        var_dump($error_msg);
        var_dump($error_file);
        var_dump($error_line);
        die();
    }

    public function shutdownErrorHandler()
    {
        $_error = error_get_last();
        if ($_error && in_array($_error['type'], array(1, 4, 16, 64, 256, 4096, E_ALL))) {
            var_dump($_error);
            //throw new FatalError();
        }

    }

    public function exceptionHandler($exception){
        call_user_func([new \App\Exceptions\Handler(),'render'],$exception);
    }
}
