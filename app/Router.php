<?php

namespace DevWeb;

/**
 * Simple route class
 */
class Route
{
    private static $routes = [];

    public static function add($route, $options)
    {
      $control = explode('@', $options['control']);

      // Testar iniciando a varivael no propio if
      if (in_array($route, array_map(function($r) { return $r['uri']; }, self::$routes)) &&
          in_array($options['request'], array_map(function($r) { return $r['request']; }, self::$routes))
        ){
          return;
      };

      self::$routes[] = [
        'uri'     => $route,
        'control' => $control[0],
        'method'  => $control[1] ?? 'execute',
        'request' => $options['request'] ?? 'GET'
      ];
    }

    public static function add_post($route, $options)
    {
      self::add($route, array_merge($options, ['request' => 'POST']));
    }

    public function execute($url)
    {
      $page = array_filter(self::$routes, function ($value) use ($url) {
        return $value['uri'] === $url && $value['request'] === $_SERVER['REQUEST_METHOD'];
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
