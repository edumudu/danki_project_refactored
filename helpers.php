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

  return $cargos[auth()->user->cargo];
}

function auth() {
  return json_decode(json_encode($_SESSION['auth']));
}

/**
 * @param string uma string com o valor base para o slug
 * 
 * @return string Retorna um slug da string passada
 */

function generateSlug($str){
  $str = mb_strtolower($str); // strtolower() que funciona com utf-8
  $str = preg_replace('/(á|à|ã|â)/', 'a', $str);
  $str = preg_replace('/(é|è|ê)/', 'e', $str);
  $str = preg_replace('/(í|ì|î)/', 'i', $str);
  $str = preg_replace('/(ú|ù|û)/', 'u', $str);
  $str = preg_replace('/(ó|ò|õ|ô)/', 'o', $str);
  $str = preg_replace('/(_|\/|!|\?|#)/', '', $str);
  $str = preg_replace('/( )/', '-', $str);
  $str = preg_replace('/(ç)/', 'c', $str);
  $str = preg_replace('/(,)/', '-', $str);
  $str = preg_replace('/(-[-]{1,})/', '-', $str);
  
  return $str;
}

// EOF
