<?php

function page($file) {
    return 'pages/' . $file . '.phtml';
}

function asset($file, $is_panel = false) {
  if ($is_panel)
    return INCLUDE_PATH_PANEL . $file;
  else
    return PATH . 'public/' . $file;
}

function route($route) {
    return PATH . preg_replace('/(\/)/', '', $route, 1);
}

// EOF
