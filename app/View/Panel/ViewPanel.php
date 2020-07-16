<?php

namespace DevWeb\View\Panel;

class ViewPanel
{
    protected $page_head = "panel/templates/head";
    protected $header = "panel/templates/header";
    protected $aside = "panel/aside";
    protected $footer = "panel/templates/footer";
    protected $page = "";

    protected $default_data = [
        'scripts' => [
            'functions.js',
            'formularios.js'
        ]
    ];

    public function render($page, $data, $need_aside = true)
    {
        extract(array_merge($data, $this->default_data));

        $this->page = $page;

        include page($this->page_head);
        include page($need_aside ? $this->aside : '');
        include page('panel/' . $page);
        include page($this->footer);
    }

    public function add_script($script) : void
    {
        array_push($this->default_data['scripts'], $script);
    }

    public function remove_script($script) : void
    {
        $index = array_search($script, $this->default_data['scripts']);
        unset($this->default_data['scripts'][$index]);
    }
}

// EOF
