<?php

use DevWeb\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/page-not-found', 'NotFoundController@index');

$router->get('/contato', 'ContactController');
$router->get('/news', 'NewsController');
$router->post('/news', 'NewsController@redirect_to_single@index');
$router->get('/news/{category}', 'NewsController@search');

// Panel
$router->get('/panel', 'Panel\\PanelHomeController');
$router->get('/panel/permission-denied', 'Panel\\PanelHomeController');

$router->get('/panel/login', 'Panel\\SessionController@create');
$router->post('/panel/login', 'Panel\\SessionController@store');
$router->get('/panel/logout', 'Panel\\SessionController@destroy');

$router->get('/panel/site/edit', 'Panel\\SiteController@edit');
$router->post('/panel/site/edit', 'Panel\\SiteController@update');

$router->get('/panel/depoiments', 'Panel\\DepoimentosController@index');
$router->post('/panel/depoiments/create', 'Panel\\DepoimentosController@store');
$router->get('/panel/depoiments/create', 'Panel\\DepoimentosController@create');
$router->post('/panel/depoiments/edit', 'Panel\\DepoimentosController@update');
$router->get('/panel/depoiments/edit', 'Panel\\DepoimentosController@edit');
$router->delete('/panel/depoiments', 'Panel\\DepoimentosController@destroy');
$router->post('/panel/depoiments/order', 'Panel\\DepoimentosController@order');

$router->get('/panel/service', 'Panel\\ServiceController@index');
$router->post('/panel/service/create', 'Panel\\ServiceController@store');
$router->get('/panel/service/create', 'Panel\\ServiceController@create');
$router->post('/panel/service/edit', 'Panel\\ServiceController@update');
$router->get('/panel/service/edit', 'Panel\\ServiceController@edit');
$router->delete('/panel/service', 'Panel\\ServiceController@destroy');
$router->post('/panel/service/order', 'Panel\\ServiceController@order');

$router->get('/panel/slide', 'Panel\\SlideController@index');
$router->post('/panel/slide/create', 'Panel\\SlideController@store');
$router->get('/panel/slide/create', 'Panel\\SlideController@create');
$router->post('/panel/slide/edit', 'Panel\\SlideController@update');
$router->get('/panel/slide/edit', 'Panel\\SlideController@edit');
$router->delete('/panel/slide', 'Panel\\SlideController@destroy');
$router->post('/panel/slide/order', 'Panel\\SlideController@order');

$router->get('/panel/notice', 'Panel\\NoticeController@index');
$router->post('/panel/notice/create', 'Panel\\NoticeController@store');
$router->get('/panel/notice/create', 'Panel\\NoticeController@create');
$router->post('/panel/notice/edit', 'Panel\\NoticeController@update');
$router->get('/panel/notice/edit', 'Panel\\NoticeController@edit');
$router->delete('/panel/notice', 'Panel\\NoticeController@destroy');

$router->get('/panel/category', 'Panel\\CategoryController@index');
$router->post('/panel/category/create', 'Panel\\CategoryController@store');
$router->get('/panel/category/create', 'Panel\\CategoryController@create');
$router->post('/panel/category/edit', 'Panel\\CategoryController@update');
$router->get('/panel/category/edit', 'Panel\\CategoryController@edit');
$router->delete('/panel/category', 'Panel\\CategoryController@destroy');
$router->post('/panel/category/order', 'Panel\\CategoryController@order');

$router->get('/panel/user/create', 'Panel\\UserController@create');
$router->post('/panel/user/create', 'Panel\\UserController@store');
$router->post('/panel/user/edit', 'Panel\\UserController@update');
$router->get('/panel/user/edit', 'Panel\\UserController@edit');

echo $router->run($router->method(), $uri);

// EOF
