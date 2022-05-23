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

    public function resolve(){
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        // foreach (self::$routes[$requestMethod] as $route => $callback) {
        //     if (preg_match_all('/{\w+}/',$route,$matches)) {
        //         echo $route;
        //     }
        // }
        
        $callback = self::$routes[$requestMethod][$requestPath];

        if ($callback instanceof Closure) {
            return include_once($callback());
        }

        echo call_user_func($callback);
    }
}