<?php

namespace DevWeb\Control;

use DevWeb\Model\Category;
use DevWeb\Model\Notice;
use DevWeb\Model\Site;

class NewsController extends Controller
{
    private $por_pag = 10;

    public function index()
    {
      $category = new Category;
      $notice = new Notice;
      $site = new Site;

      $info = [
        'title'       => 'Noticias',
        'info_author' => $site->selectSingle(['id' => 1], ['name_author', 'descricao']),
        'categorias'  => $category->selectAll(['*'], null, 'order_id ASC'),
        'noticias'     => $notice->selectAll(['*'], null, 'date ASC')
      ];

      $view = $this->view('View');
      $view->add_script('news.js');
      $view->render('news', $info);
    }

    public function redirect_to_single($post)
    {
      $search_val = $post['parametro']; 
      
      self::redirect('/news/' . $search_val);
    }

    public function search($category)
    {
      print_r($category);
    }
}

// EOF
