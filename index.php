<?php 

$uri = urldecode(
  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)){
  return false;
}

include "vendor/autoload.php";
include 'config.php'; 
include 'helpers.php';
include 'routes.php';

// EOF
