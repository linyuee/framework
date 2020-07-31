<?php
/**
 * Created by PhpStorm.
 * User: hw201902
 * Date: 2020/7/27
 * Time: 11:07
 */

namespace Lyue\Http;

class HttpKernel
{
    public static function init(Request $request){
        $path = $request->getPath();
        $action = \Lyue\Route\Router::getInstance()->findRouter(ltrim($path,'/'));
        if (!$action){
            throw new \Exception('404');
        }
        $callback = explode('@', $action);
        $class = 'App\Controllers\\' . $callback[0];
        $return = call_user_func_array(array(new $class(), $callback[1]), []);
        return  new Response($return);
    }
}
