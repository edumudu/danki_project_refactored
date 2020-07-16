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
        'slides'      => $slide->select(['name', 'slide'])->orderBy('order_id')->limit(3)->get(),
        'depoimentos' => $depoiment->select()->orderBy('order_id')->limit(3)->get(),
        'services'    => $service->select(['servico'])->orderBy('order_id')->limit(5)->get(),
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
