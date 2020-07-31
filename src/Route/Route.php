<?php

namespace Lyue\Route;
class  Route
{
    private $rule;
    private $rule_parsed = [];
    private $request_method;
    private $alias;
    private $constraint = [];
    private $action;
    private $match_all = false;

    private $params = [];


    /**
     * Route constructor.
     * @param $method string
     * @param $rule string
     * @param $action callable|string
     */
    public function __construct($method, $rule, $action)
    {
        $this->rule = $rule;
        $this->request_method = $method;
        $this->action = $action;
        $this->parseRule();
    }

    private function parseRule()
    {
        $parts = explode("/", $this->rule);
        if (count($parts) == 0) {
            $this->match_all = true;
        } else {
            foreach ($parts as $part) {
                if (preg_match('/^{([a-zA-Z]+)(\??)}$/', $part, $match) == 0) {
                    $this->rule_parsed[] = ['is_plain' => true, 'value' => $part];
                } else {
                    $this->rule_parsed[] = ['is_plain' => false, 'is_optional' => isset($match[2]) && !empty($match[2]), 'param_name' => $match[1]];
                }
            }
        }
    }

    public function where($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->constraint[$key] = $value;
            }
        } else {
            $this->constraint[$name] = $value;
        }
    }

    public function name($alias)
    {
        $this->alias = $alias;
    }


    public function getParam($name, $default = null)
    {
        return $this->params[$name] ?? $default;
    }

    /**
     * @return string
     */
    public function getRule(): string
    {
        return $this->rule;
    }

    /**
     * @return callable|string
     */
    public function getAction()
    {
        return $this->action;
    }


}