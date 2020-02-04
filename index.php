<?php 

    use DevWeb\Route;

    include "vendor/autoload.php";
    include 'config.php'; 
    include 'helpers.php';
    include 'routes.php';

    Route::execute($_GET['url'] ?: '/');
?>