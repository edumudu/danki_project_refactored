<?php

namespace DevWeb\Control;

class ContactController extends Controller
{
    public function execute()
    {
        $view = $this->view('View');
        $view->add_script('initMap.js');
        $view->render('contact', [
            'title' => 'Contato'
        ]);
    }
}

// EOF
