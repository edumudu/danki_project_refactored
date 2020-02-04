<?php

namespace DevWeb\Control;

class NotFoundController extends Controller
{
    public function execute()
    {
        $view = $this->view('View');
        $view->render('page-404', [
            'title' => 'Pagina não encontrada'
        ]);
    }
}

// EOF
