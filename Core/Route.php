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

    public static function put($path, $callback){
        self::$routes['PUT'][$path] = $callback;
    }

    public static function delete($path, $callback){
        self::$routes['DELETE'][$path] = $callback;
    }

    public function resolve(){
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes[$requestMethod] as $route => $callback) {
            // ha talál a {id}-t helyettesíti (\w+)-al ami A-Za-z0-9 karaktereket jelent
            // akár több előfordulással (+ jel), majd megnézi hogy van-e olyan
            // útvonal amire ez igaz
            $replacedRoute = '@^' . preg_replace('/{\w+}/','(\w+)',$route) . '$@';
            if (preg_match_all($replacedRoute,$requestPath,$values)) {
                for ($i=1; $i <count($values) ; $i++) { 
                    echo call_user_func($callback,$values[$i][0]);
                    exit;
                }
            }

            // ha szükség van a kérés útvonalából a kulcs típusára pl:/task/{id}->id
            // if (preg_match_all('/\{(\w+)}/',$route,$matches)) {
                
            // }
        }
        
        $callback = self::$routes[$requestMethod][$requestPath];

        if ($callback instanceof Closure) {
            return include_once($callback());
        }
        header('Content-Type: application/json');
        echo call_user_func($callback);
    }
}