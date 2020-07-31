<?php

namespace Lyue\Route;

use function Couchbase\defaultDecoder;

/**
 * @method static \RouteRegistrar where($name, $value = null)
 * @method static \RouteRegistrar namespace($namespace)
 * @method static \RouteRegistrar prefix($prefix)
 * **/
class  Router
{
    const REQUEST_METHOD_GET = "GET";
    const REQUEST_METHOD_POST = "POST";

    private static $instance = null;

    private $routeCollection = [];

    private $groupStack = [];
    private $rules = [];

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * add route to container
     * @param Route $route
     */
    private function addRouteToContainer(Route $route)
    {
        $this->routeCollection[] = $route;
        $this->rules[$route->getRule()] = $route->getAction();
    }

    public function getRouteCollection()
    {
        return $this->routeCollection;
    }

    /**
     * syntax sugar for get request
     * @param $rule string
     * @param $action string
     * @return  Route
     */
    public static function get($rule, $action)
    {
        $route = self::newRoute(self::REQUEST_METHOD_GET, $rule, $action);
        self::getInstance()
            ->addRouteToContainer($route);
        return $route;
    }

    /**
     * syntax sugar for post request
     * @param $rule string
     * @param $action string
     * @return  Route
     */
    public static function post($rule, $action)
    {
        $route = self::newRoute(self::REQUEST_METHOD_POST, $rule, $action);
        self::getInstance()
            ->addRouteToContainer($route);
        return $route;
    }

    /**
     * create  a new route
     * @param $method
     * @param $rule
     * @param $action
     * @return  Route
     */
    private static function newRoute($method, $rule, $action)
    {
        $inst = self::getInstance();
        if (!empty($inst->groupStack)) {
            $attributes = end($inst->groupStack);
            $rule = isset($attributes['prefix']) ?
                rtrim($attributes['prefix'], '/') . '/' . $rule : $rule;
            if (is_string($action) && isset($attributes['namespace'])) {
                $action = trim($attributes['namespace'], '\\') . '\\' . $action;
            }

        } else {
            $attributes = [];
        }
        $route = new Route($method, $rule, $action);
        if (isset($attributes['where'])) {
            $route->where($attributes['where']);
        }
        return $route;
    }

    private function updateGroupStack(array $attributes)
    {
        if (!empty($this->groupStack)) {
            $new_attributes = [];
            $last_attribute = end($this->groupStack);
            $new_attributes['where'] =
                array_merge($last_attribute['where'] ?? [], $attributes['where'] ?? []);
            $new_attributes['prefix'] = isset($last_attribute['prefix'])
                ? ($last_attribute['prefix'] . (isset($attributes['prefix']) ? '/' . $attributes['prefix'] : ''))
                : ($attributes['prefix'] ?? '');
            $new_attributes['namespace'] = isset($last_attribute['namespace'])
                ? ($last_attribute['namespace'] . (isset($attributes['namespace']) ? '/' . $attributes['namespace'] : ''))
                : ($attributes['namespace'] ?? '');
            $this->groupStack[] = $new_attributes;
        } else {
            $this->groupStack[] = $attributes;
        }
    }

    public function group($attributes, callable $callback)
    {
        $this->updateGroupStack($attributes);
        $callback(self::getInstance());
        array_pop($this->groupStack);
    }

    public static function __callStatic($name, $arguments)
    {
        if (in_array($name, ['where', 'namespace', 'prefix'])) {
            return (new RouteRegistrar(self::getInstance()))->$name($arguments[0]);
        } else {
            throw new RuntimeException("method ${name} not exist");
        }
    }

    public function findRouter($rule)
    {
        return array_key_exists($rule, $this->rules) ? $this->rules[$rule] : false;
    }
}