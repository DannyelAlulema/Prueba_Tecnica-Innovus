<?php

namespace Core;

class Router
{
    private $routes = [];
    private $middleware = [];

    public function get($path, $handler, $middleware = []) {
        $this->addRoute('GET', $path, $handler, $middleware);
    }
    
    public function post($path, $handler, $middleware = []) {
        $this->addRoute('POST', $path, $handler, $middleware);
    }
    
    public function patch($path, $handler, $middleware = []) {
        $this->addRoute('PATCH', $path, $handler, $middleware);
    }
    
    public function put($path, $handler, $middleware = []) {
        $this->addRoute('PUT', $path, $handler, $middleware);
    }

    public function delete($path, $handler, $middleware = []) {
        $this->addRoute('DELETE', $path, $handler, $middleware);
    }

    public function middleware($middleware) {
        $this->middleware[] = $middleware;
    }

    private function addRoute($method, $path, $handler, $middleware = []) {
        $this->routes[$method][$path] = [
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    function dispatch($method, $uri) {
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $path => $route) {
                if ($this->isMatchingPath($uri, $path)) {
                    $this->callMiddleware($route['middleware']);
                    $this->callHandler($route['handler']);
                    return;
                }
            }
        }
        $this->notFound();
    }

    private function callMiddleware($middleware) {
        foreach ($middleware as $middlewareClass) {
            $middlewareInstance = new $middlewareClass;
            $middlewareInstance->handle();
        }
    }

    private function callHandler($handler) {
        $controller = $handler[0];
        $method = $handler[1];

        $controllerInstance = new $controller;
        
        if (method_exists($controllerInstance, $method))
            $controllerInstance->$method();
        else
            echo 'Method not exists';
    }

    private function isMatchingPath($uri, $path) {
        return $uri == $path;
    }

    private function notFound() {
        echo "Route not found";
    }
}
