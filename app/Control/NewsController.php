<?php

namespace DevWeb\Control;

use DevWeb\Model\Painel;
use DevWeb\Route;

class NewsController extends Controller
{
    private $por_pag = 10;

    public function execute()
    {
        // Pega informações necessarias para a pagina

        $info = [
            'title'       => 'Noticias',
            'info_author' => Painel::selectSingle('tb_site.config', ['id' => 1], ['name_author', 'descricao']),
            'categorias'  => Painel::selectAll('tb_site.categorias', ['*'], null, 'order_id ASC'),
            'noticias'     => Painel::selectAll('tb_site.noticias', ['*'], null, 'date ASC')
        ];

        $view = $this->view('View');
        $view->add_script('news.js');
        $view->render('news', $info);
    }

    public function redirect_to_single($post)
    {
        $search_val = $post['parametro']; 
        
        Route::redirect('news/' . $search_val);
    }

    public function search($category)
    {
        print_r($category);
    }
}

// EOF
