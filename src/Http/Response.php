<?php
/**
 * Created by PhpStorm.
 * User: hw201902
 * Date: 2020/7/28
 * Time: 18:41
 */

namespace Lyue\Http;


use Lyue\Exception\SystemException;

class Response
{
    private $data;
    private $header = [];

    public function __construct($return)
    {
        if (!is_string($return)) throw new SystemException('The Response content must be a string or object implementing __toString()');
        $this->data = $return;
    }

    public function setHeader($headerr):array
    {

    }

    public function render()
    {
        echo  $this->data;
    }
}
