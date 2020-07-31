<?php
/**
 * Created by PhpStorm.
 * User: hw201902
 * Date: 2020/7/27
 * Time: 9:29
 */

namespace Lyue\Http;

class Request
{
    private $params = [];

    private $headers = [];


    private $path;

    private $method;

    private $query;

    private $payload;
    private static $methodArr = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    public function __construct()
    {

    }

    public function getPath(){
        return $_SERVER['REQUEST_URI'];
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getMethod()
    {
        return empty($this->method) ? 'GET' : $this->method;
    }

    public function getBody()
    {
        return $this->payload;
    }
}