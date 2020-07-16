<?php

namespace DevWeb\View;

class View
{
    protected $page_head = "templates/head";
    protected $header = "templates/header";
    protected $footer = "templates/footer";
    protected $page = "";

    protected $default_data = [
        'scripts' => [
            'functions.js',
            'formularios.js'
        ]
    ];

    public function render($page, $data) : void
    {
        extract(array_merge($data, $this->default_data));

        $this->page = $page;

        include page($this->page_head);
        include page($this->header);
        include page($page);
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
