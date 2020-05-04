<?php

function page($file) {
  return 'pages/' . $file . '.phtml';
}

function asset($file) {
  return PATH . '/public/' . $file;
}

function route($route) {
  return strlen($route) > 1 ? PATH . preg_replace('/(\/)$/', '', $route, 1) : $route;
}

function getIP(){
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }

  return $ip;
}

function getCargo() {
  $cargos = [
    'Normal',
    'Subadministrador',
    'Administrador'
  ];

  return $cargos[$_SESSION['cargo']];
}

// EOF
