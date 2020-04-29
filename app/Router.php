<?php

namespace DevWeb;

/**
 * Simple route class
 */
class Route
{
    private static $routes = [];

    private static function add($route, $options)
    {
      $control = explode('@', $options['control']);

      // Testar iniciando a varivael no propio if
      if (array_reduce(self::$routes, fn($result, $r) => $r['uri'] === $route && $options['request'] === $r['request'], false)){
          return;
      };

      self::$routes[] = [
        'uri'     => $route,
        'control' => $control[0],
        'method'  => $control[1] ?? 'index',
        'request' => $options['request']
      ];
    }

    public static function get($route, $options)
    {
      self::add($route, array_merge($options, ['request' => 'GET']));
    }

    public static function post($route, $options)
    {
      self::add($route, array_merge($options, ['request' => 'POST']));
    }

    public static function delete($route, $options)
    {
      self::add($route, array_merge($options, ['request' => 'DELETE']));
    }

    public function execute($url)
    {
      $page = array_filter(self::$routes, function ($value) use ($url) {
        return $value['uri'] === explode('?', $url)[0] && $value['request'] === $_SERVER['REQUEST_METHOD'];
      }) ?? NULL;

      $page = array_shift($page);

      if (!$page)
        self::redirect('page-not-found');

      $controller = '\DevWeb\Control\\' . preg_replace('/\//', '\\', $page['control']);
      $controller = new $controller;
      $controller->{$page['method']}($_POST ?? null);
    }

    public function redirect($url)
    {
        die('<script>
                location.href = "' . PATH . $url . '"
            </script>');
    }
}

// EOF
