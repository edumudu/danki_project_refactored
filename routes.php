<?php

use DevWeb\Route;

Route::add('/', ['control' => 'HomeController']);

Route::add('/page-not-found', ['control' => 'NotFoundController']);

Route::add('/sobre', ['control' => 'HomeController@about']);
Route::add('/servicos', ['control' => 'HomeController@servicos']);
Route::add('/contato', ['control' => 'ContactController']);
Route::add('/news', ['control' => 'NewsController']);
Route::add_post('/news', ['control' => 'NewsController@redirect_to_single']);
Route::add('/news/{category}', ['control' => 'NewsController@search']);

// Panel
Route::add('/panel', ['control' => 'Panel/PanelHomeController']);

Route::add_post('/panel/login', ['control' => 'Panel/SessionController@create']);
Route::add('/panel/login', ['control' => 'Panel/SessionController']);

// EOF
