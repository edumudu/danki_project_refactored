<?php

namespace DevWeb\Control;

use DevWeb\Model\Site;

class Controller
{
    public function __construct()
    {
        self::update_users_online();
    }

    public function view($viewname)
    {
        $view = '\DevWeb\View\\' . $viewname;
        return $view = new $view;
    }

    protected static function update_users_online()
    {
        //  Atualiza os usuarios online
        Site::updateUserOnline();
        Site::contador();
    }
}

// EOF
