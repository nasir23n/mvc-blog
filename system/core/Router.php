<?php

namespace System\Core;

class Router
{
    public $request;
    protected static array $routes = [];

    public function __construct() {
        $this->request = new Request();
    }
    public static function get($path, $callback) {
        $path = trim($path, '/');
        if (empty($path)) $path = '/';
        self::$routes['get'][$path] = $callback;
    }
    public static function post($path, $callback) {
        $path = trim($path, '/');
        if (empty($path)) $path = '/';
        self::$routes['post'][$path] = $callback;
    }
    
    public function render() {
        $path = $_SERVER['PATH_INFO'] ?? '/';
        $path = trim($path, '/');
        if (empty($path)) $path = '/'; 
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $callback = self::$routes[$method][$path] ?? false;
        if (is_callable($callback)) {
            call_user_func($callback);
        }

        if (is_string($callback)) {
            view($callback);
        }

        if ($callback === false) {
            _404();
        }
        if (is_array($callback)) {
            $obj = new $callback[0]();
            $method = $callback[1];
            if (method_exists($obj, $method)) {
                call_user_func(array($obj, $method), $this->request);
            } else {
                die('Method `$method` is not defined');
            }
        }
    }
}
