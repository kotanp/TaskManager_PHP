<?php

namespace App\Core;
use Closure;

class Route{
    private static array $routes; 

    public static function get($path, $callback){
        self::$routes['GET'][$path] = $callback;
    }

    public static function post($path, $callback){
        self::$routes['POST'][$path] = $callback;
    }

    public function run(){
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        //$requestQuery = $requestUri['query'];
        $callback = null;
        foreach (self::$routes[$requestMethod] as $key => $value) {
            if ($key === $requestPath) {
                $callback = $value;
            }
        }

        if ($callback instanceof Closure) {
            return include_once($callback());
        }
        echo $callback;
    }
}