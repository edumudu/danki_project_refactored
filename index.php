<?php 

    use DevWeb\Route;

    include "vendor/autoload.php";
    include 'config.php'; 
    include 'helpers.php';
    include 'routes.php';

    $uri = strlen($_SERVER['REQUEST_URI']) > 1 ? preg_replace('/\/$/', '', $_SERVER['REQUEST_URI']) : $_SERVER['REQUEST_URI'];

    Route::execute($uri);
?>  