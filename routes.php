<?php

use DevWeb\Route;

Route::get('/', ['control' => 'HomeController']);

Route::get('/page-not-found', ['control' => 'NotFoundController']);

Route::get('/sobre', ['control' => 'HomeController@about']);
Route::get('/servicos', ['control' => 'HomeController@servicos']);
Route::get('/contato', ['control' => 'ContactController']);
Route::get('/news', ['control' => 'NewsController']);
Route::post('/news', ['control' => 'NewsController@redirect_to_single']);
Route::get('/news/{category}', ['control' => 'NewsController@search']);

// Panel
Route::get('/panel', ['control' => 'Panel/PanelHomeController']);

Route::post('/panel/login', ['control' => 'Panel/SessionController@create']);
Route::get('/panel/login', ['control' => 'Panel/SessionController']);

Route::get('/panel/depoiments', ['control' => 'Panel/DepoimentosController@index']);
Route::post('/panel/depoiments/create', ['control' => 'Panel/DepoimentosController@store']);
Route::get('/panel/depoiments/create', ['control' => 'Panel/DepoimentosController@create']);
Route::delete('/panel/depoiments', ['control' => 'Panel/DepoimentosController@destroy']);
Route::post('/panel/depoiments/edit', ['control' => 'Panel/DepoimentosController@update']);
Route::get('/panel/depoiments/edit', ['control' => 'Panel/DepoimentosController@edit']);

Route::get('/panel/service', ['control' => 'Panel/ServiceController@index']);
Route::post('/panel/service/create', ['control' => 'Panel/ServiceController@store']);
Route::get('/panel/service/create', ['control' => 'Panel/ServiceController@create']);
Route::post('/panel/service/edit', ['control' => 'Panel/ServiceController@update']);
Route::get('/panel/service/edit', ['control' => 'Panel/ServiceController@edit']);

Route::get('/panel/slide', ['control' => 'Panel/SlideController@index']);
Route::post('/panel/slide/create', ['control' => 'Panel/SlideController@store']);
Route::get('/panel/slide/create', ['control' => 'Panel/SlideController@create']);
Route::post('/panel/slide/edit', ['control' => 'Panel/SlideController@update']);
Route::get('/panel/slide/edit', ['control' => 'Panel/SlideController@edit']);

Route::get('/panel/notice', ['control' => 'Panel/NoticeController@index']);
Route::post('/panel/notice/create', ['control' => 'Panel/NoticeController@store']);
Route::get('/panel/notice/create', ['control' => 'Panel/NoticeController@create']);
Route::post('/panel/notice/edit', ['control' => 'Panel/NoticeController@update']);
Route::get('/panel/notice/edit', ['control' => 'Panel/NoticeController@edit']);

Route::get('/panel/category', ['control' => 'Panel/CategoryController@index']);
Route::post('/panel/category/create', ['control' => 'Panel/CategoryController@store']);
Route::get('/panel/category/create', ['control' => 'Panel/CategoryController@create']);
Route::post('/panel/category/edit', ['control' => 'Panel/CategoryController@update']);
Route::get('/panel/category/edit', ['control' => 'Panel/CategoryController@edit']);

Route::post('/panel/user/edit', ['control' => 'Panel/UserController@update']);
Route::get('/panel/user/edit', ['control' => 'Panel/UserController@edit']);

// EOF
