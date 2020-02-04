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
        if (in_array($route, array_keys(self::$routes))){
            $this_route = self::$routes[$route];
            if ($this_route['request'] === $options['request']) return;
            $route .= '-post';
        };


        self::$routes[$route] = [
            'control' => $control[0],
            'method'  => $control[1] ?? 'execute',
            'request' => $options['request'] ?? 'get'
        ];

    }

    public static function add_post($route, $options)
    {
        self::add($route, array_merge($options, ['request' => 'post']));
    }

    public function execute($url)
    {
        

        // Para impedir que paginas post sejam consideradas como conteudo para ser carregado
        $real_pages = array_filter(self::$routes, function($value){ return $value['request'] === 'get'; });
        if (!in_array($url, array_keys($real_pages)))
            self::redirect('page-not-found');
        
        // Para paginas adicionadas como post
        if (!empty($_POST)) 
            $url .= '-post';

        $route_op = self::$routes[$url];

        $controller = '\DevWeb\Control\\' . $route_op['control'];
        $controller = new $controller;
        $controller->{$route_op['method']}($_POST ?? null);
    }

    public function redirect($url)
    {
        die('<script>
                location.href = "' . PATH . $url . '"
            </script>');
    }
}

// EOF
