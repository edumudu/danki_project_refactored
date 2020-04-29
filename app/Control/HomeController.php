<?php

namespace DevWeb\Control;

use DevWeb\Model\Painel;

class HomeController extends Controller
{
    public function index() 
    {
        // Renderiza a view
        $this->view('Home')
             ->render('home', $this->get_info());
    }

    public function about()
    {
        $view = $this->view('Home');
        $view->render('home', $this->get_info());
    }

    public function servicos()
    {
        $view = $this->view('Home');
        $view->render('home', $this->get_info());
    }

    public function get_info()
    {
        // Pega as informações basicas para carregar o site
        $site_info = Painel::selectSingle('tb_site.config',['id' => 1]);

        return [
            'title'       => 'Home',
            'name_author' => $site_info['name_author'],
            'description' => $site_info['descricao'],
            'icone_1'     => $site_info['icone_1'],
            'icone_2'     => $site_info['icone_2'],
            'icone_3'     => $site_info['icone_3'],
            'descricao_1' => $site_info['descricao_1'],
            'descricao_2' => $site_info['descricao_2'],
            'descricao_3' => $site_info['descricao_3'],
            'slides'      => Painel::selectAll('tb_site.slides', ['name', 'slide'], null, 'order_id ASC', 0, 3),
            'depoimentos' => Painel::selectAll('tb_site.depoimentos', ['*'], null, 'order_id ASC', 0, 3),
            'services'    => Painel::selectAll('tb_site.servicos', ['servico'], null, 'order_id ASC', 0, 5)
        ];
    }
}

// EOF
