<?php
namespace Lyue\Route;
class  RouteRegistrar
{
    /**
     * @var $router Router
     * **/
    private $router;

    private $attributes = [];

    public function __construct(Router $router)
    {
        $this->router = $router;
    }


    public function where($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->attributes['where'][$key] = $value;
            }
        } else {
            $this->attributes['where'][$name] = $value;
        }
        return $this;
    }


    public function namespace($namespace)
    {
        $this->attributes['namespace'] = $namespace;
        return $this;
    }

    public function prefix($prefix)
    {
        $this->attributes['prefix'] = $prefix;
        return $this;
    }

    public function group(callable $callback)
    {
        $this->router->group($this->attributes, $callback);
        return $this;
    }

}