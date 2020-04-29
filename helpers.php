<?php

function page($file) {
  return 'pages/' . $file . '.phtml';
}

function asset($file) {
  return PATH . 'public/' . $file;
}

function route($route) {
  return PATH . preg_replace('/(\/)/', '', $route, 1);
}

// EOF
