<?php

namespace DevWeb\Control;

use DevWeb\Model\Site;
use DevWeb\Model\Slide;
use DevWeb\Model\Depoiment;
use DevWeb\Model\Service;

class HomeController extends Controller
{
    public function index() 
    {
      $view = $this->view('Home');

      $slide = new Slide;
      $depoiment = new Depoiment;
      $service = new Service;
      $site = new Site;
      $site_info = $site->selectSingle(['id' => 1]);

      $view->add_script('slider.js');
      $view->render('home', [
        'title'       => 'Home',
        'slides'      => $slide->selectAll(['name', 'slide'], null, 'order_id ASC', 0, 3),
        'depoimentos' => $depoiment->selectAll(['*'], null, 'order_id ASC', 0, 3),
        'services'    => $service->selectAll(['servico'], null, 'order_id ASC', 0, 5),
        'name_author' => $site_info['name_author'],
        'description' => $site_info['descricao'],
        'icone_1'     => $site_info['icone_1'],
        'icone_2'     => $site_info['icone_2'],
        'icone_3'     => $site_info['icone_3'],
        'descricao_1' => $site_info['descricao_1'],
        'descricao_2' => $site_info['descricao_2'],
        'descricao_3' => $site_info['descricao_3'],
    ]);
    }
}

// EOF
