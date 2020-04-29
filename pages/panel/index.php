<?php

  use DevWeb\Route;

  include "../vendor/autoload.php";
  include '../config.php'; 
  include '../helpers.php';
  include '../routes.php';

  $uri = preg_replace('/\/$/', '',$_SERVER['REQUEST_URI']);

  Route::execute($uri);

// EOF
