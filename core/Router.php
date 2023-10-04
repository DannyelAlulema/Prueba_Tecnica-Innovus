<?php

namespace Core;

class Router
{
    use Responser;

    private $routes = [];
    private $middleware = [];
    private $params = [];

    public function get($path, $handler, $middleware = []) {
        $this->addRoute('GET', $path, $handler, $middleware);
    }
    
    public function post($path, $handler, $middleware = []) {
        $this->addRoute('POST', $path, $handler, $middleware);
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
                    // Obtiene el contenido del cuerpo de la solicitud
                    $requestBody = file_get_contents('php://input');
                    $requestData = json_decode($requestBody, true);

                    $this->callHandler($route['handler'], $requestData);
                    return;
                }
                $this->params = [];
            }
        }
        $this->notFound();
    }

    private function callMiddleware($middleware) {
        foreach ($middleware as $middlewareClass) {
            $middlewareInstance = new $middlewareClass;
            $middlewareInstance->handle();
        }

        if (isset($_REQUEST['decoded_jwt']))
            unset($_REQUEST['decoded_jwt']);
    }

    private function callHandler($handler, $requestData) {
        $controller = $handler[0];
        $method = $handler[1];

        $controllerInstance = new $controller;
        $params = array_merge([$requestData], $this->params);
        
        if (method_exists($controllerInstance, $method))
            call_user_func_array([$controllerInstance, $method], $params);
        else
            $this->errorResponse('Method not exists', 404);
    }

    private function isMatchingPath($uri, $path) {
        $uriSegments = explode('/', trim($uri, '/'));
        $pathSegments = explode('/', trim($path, '/'));
        $params = [];
    
        if (count($uriSegments) !== count($pathSegments)) {
            return false;
        }
    
        foreach ($pathSegments as $key => $segment) {
            if ($segment !== $uriSegments[$key] && strpos($segment, '{') !== false) {
                $paramName = trim($segment, '{}');
                $params[$paramName] = $uriSegments[$key];
            } elseif ($segment !== $uriSegments[$key]) {
                return false;
            }
        }
        
        $this->params = $params;
        return true;
    }    

    private function notFound() {
        $this->errorResponse('Method not exists', 404);
    }
}
