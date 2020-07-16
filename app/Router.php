<?php

namespace DevWeb;

/**
 * Simple route class
 */
class Router
{
    private $routes = [];

    public function method() : string
    {
      return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'cli';
    }

    private function on(string $method, string $path, string $callback) : Router
    {
      $method = strtoupper($method);

      if (!isset($this->routes[$method])) {
        $this->routes[$method] = [];
      }

      $uri = substr($path, 0, 1) !== '/' ? '/' . $path : $path;
      $pattern = str_replace('/', '\/', $uri);
      $pattern = preg_replace('/{\w+}/', '(\w+)', $pattern);
      $route = '/^' . $pattern . '$/';

      $this->routes[$method][$route] = $callback;

      return $this;
    }

    public function run(string $method, string $uri)
    {
      $method = strtoupper($method);
      if (!isset($this->routes[$method])) {
        return null;
      }

      foreach($this->routes[$method] as $route => $callback) {
        if (preg_match($route, $uri, $parameters)) {
          array_shift($parameters);

          return $this->call($callback, $parameters);
        }
      }

      return null;
    }

    public function get(string $uri, string $action) : Router
    {
      return $this->on('GET', $uri, $action);
    }

    public function post(string $uri, string $action) : Router
    {
      return $this->on('POST', $uri, $action);
    }

    public function put(string $uri, string $action) : Router
    {
      return $this->on('PUT', $uri, $action);
    }

    public function delete(string $uri, string $action) : Router
    {
      return $this->on('DELETE', $uri, $action);
    }

    private function call (string $callback, array $paramns)
    {
      [$controller, $method] = explode('@', $callback);
      
      $controller = '\DevWeb\Control\\' . $controller;
      $method = $method ?? 'index';

      call_user_func_array([new $controller, $method], $paramns);

      return null;
    }
}

// EOF
