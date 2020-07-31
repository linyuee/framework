<?php
/**
 * Created by PhpStorm.
 * User: hw201902
 * Date: 2020/7/29
 * Time: 16:29
 */

namespace Lyue\Exception;


use Throwable;

class FatalError extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
